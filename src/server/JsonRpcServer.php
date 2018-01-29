<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\server;

use dmazurek\JsonRpc\config\JsonRpcConfig;
use dmazurek\JsonRpc\error\JsonRpcErrorCodes;
use dmazurek\JsonRpc\exception\InvalidParams;
use dmazurek\JsonRpc\exception\InvalidRequest;
use dmazurek\JsonRpc\exception\MethodNotFoundException;
use dmazurek\JsonRpc\exception\ParseError;
use dmazurek\JsonRpc\io\JsonRpcInput;
use dmazurek\JsonRpc\request\IdentifiedJsonRpcRequest;
use dmazurek\JsonRpc\request\JsonRpcRequest;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;
use dmazurek\JsonRpc\request\Notification;
use dmazurek\JsonRpc\response\FailedResponse;
use dmazurek\JsonRpc\response\JsonRpcResponse;
use dmazurek\JsonRpc\response\NotificationResponse;
use dmazurek\JsonRpc\response\Response;
use Throwable;

class JsonRpcServer
{
    private $config;
    /**
     * @var JsonRpcInput
     */
    private $input;
    /**
     * @var JsonRpcRequestBuilder
     */
    private $requestBuilder;

    public function __construct(JsonRpcConfig $config, JsonRpcInput $input, JsonRpcRequestBuilder $requestBuilder)
    {
        $this->config = $config;
        $this->input = $input;
        $this->requestBuilder = $requestBuilder;
    }

    public function run()
    {
        return $this->handleRequest(
            $this->input->readFromInput()
        );
    }

    private function handleRequest(string $json): JsonRpcResponse
    {
        $result = null;
        $error = null;

        try {
            $request = $this->requestBuilder->build($json);
            $handler = $this->config->getMethodHandler($request->getMethod());
            $result = $handler($request);
            return $this->createJsonRpcResponse($request, $result, $error);
        } catch (MethodNotFoundException $exception) {
            $error = [
                'code' => JsonRpcErrorCodes::METHOD_NOT_FOUND,
                'message' => 'Method not found'
            ];
        } catch (ParseError $exception) {
            $error = [
                'code' => JsonRpcErrorCodes::PARSE_ERROR,
                'message' => 'Parse error'
            ];
        } catch (InvalidParams $exception) {
            $error = [
                'code' => JsonRpcErrorCodes::INVALID_PARAMS,
                'message' => 'Invalid params'
            ];
        } catch (InvalidRequest $exception) {
            $error = [
                'code' => JsonRpcErrorCodes::INVALID_REQUEST,
                'message' => 'Invalid request'
            ];
        } catch(Throwable $exception) {
            $error = [
                'code' => JsonRpcErrorCodes::INTERNAL_ERROR,
                'message' => 'Internal error'
            ];
        }

        return $this->createErrorResponse($error);
    }

    /**
     * @param JsonRpcRequest $request
     * @param null $result
     * @param null $error
     * @return JsonRpcResponse
     * @throws InvalidRequest
     */
    private function createJsonRpcResponse(JsonRpcRequest $request, $result = null, $error = null): JsonRpcResponse
    {
        if ($request instanceof Notification) {
            return new NotificationResponse();
        }

        if ($request instanceof IdentifiedJsonRpcRequest) {
            return new Response(
                $request->getApiVersion(),
                $request->getRequestId(),
                $result,
                $error
            );
        }

        throw new InvalidRequest();
    }

    private function createErrorResponse(array $error): JsonRpcResponse
    {
        return new FailedResponse($error['code'], $error['message']);
    }
}
