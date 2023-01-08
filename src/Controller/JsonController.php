<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JsonController extends Controller
{

    /**
     * @param $data
     * @param string|null $location
     * @return JsonResponse
     */
    protected function respondCreated($data, ?string $location = null): JsonResponse
    {
        $headers = [];
        if ($location) {
            $headers['Location'] = $location;
        }

        return $this->respond($data, JsonResponse::HTTP_CREATED, $headers);
    }

    /**
     * @return JsonResponse
     */
    protected function respondNoContent(): JsonResponse
    {
        return $this->respond(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param string|null $url
     * @param int $status
     * @param array $headers
     * @return RedirectResponse
     */
    protected function redirect(?string $url, int $status = 302, array $headers = []): RedirectResponse
    {
        return new RedirectResponse($url, $status, $headers);
    }    protected function respond($data, int $status = 200, array $headers = [], $groups = [], $exclude = []): JsonResponse
{
    return new JsonResponse($this->serialize($data, $groups, $exclude), $status, $headers, true);
}

    protected function serialize($data, array $groups = [], array $exclude = []): ?string
    {
        if (null === $data) {
            return '';
        }

        if (is_string($data)) {
            return $data;
        }

        $groups = array_merge(static::$serializeGroups, $groups);
        if ($exclude) {
            $groups = array_diff($groups, $exclude);
        }

        $context = [
            'groups' => $groups,
        ];

        return $this->getSerializer()->serialize($data, 'json', $context);
    }


}
