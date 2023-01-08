<?php

namespace App\Controller;

use App\Dataset\DatasetInterface;
use App\Exception\NotValidatedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class JsonController extends Controller
{

    protected function respond($data, int $status = 200, array $headers = [], $groups = [], $exclude = []): JsonResponse
    {
        return new JsonResponse($this->serialize($data, $groups, $exclude), $status, $headers, true);
    }

    protected function deserializeAndValidate($data, string $type, ...$groups): DatasetInterface
    {
        $dataset = $this->deserialize($data, $type, ...$groups);

        $errors = $this->validate($dataset);
        if ($errors->count()) {
            throw new NotValidatedHttpException($errors);
        }

        return $dataset;
    }

    protected function validate(DatasetInterface $value, ...$groups): ConstraintViolationListInterface
    {
        return $this->getValidator()->validate($value, null, $groups);
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

    protected function deserialize($data, $type, ...$groups): DatasetInterface
    {
        $context = [];

        if (is_object($type)) {
            $context['object_to_populate'] = $type;
            $type = get_class($type);
        }

        if ($groups) {
            $context['groups'] = $groups;
        }

        if (is_string($data)) {
            $data = $this->transform($data);
        } else {
            $data = is_array($data) ? json_encode($data) : $data;
        }

        try {
            $result = $this->getSerializer()->deserialize($data, $type, 'json', $context);

            if ($result instanceof DatasetInterface) {
                return $result;
            }

            $message = $this->getTranslator()->trans('entity.unprocessable');
            throw new UnprocessableEntityHttpException($message);
        } catch (NotEncodableValueException $exception) {
            $message = $this->getTranslator()->trans('json.invalid');
            throw new BadRequestHttpException($message);
        } catch (\Exception $exception) {
            $message = $this->getTranslator()->trans('entity.unprocessable');
            throw new UnprocessableEntityHttpException($message);
        }
    }

    private function transform(string $data): string
    {
        $array = json_decode($data);

        $transformed = [];

        foreach ($array as $key => $value) {
            $newKey = $this->underscoreToCamelCase($key);
            $transformed[$newKey] = $value;
        }

        return json_encode($transformed);
    }

    private function underscoreToCamelCase(string $value): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));
        $str[0] = strtolower($str[0]);

        return $str;
    }
}
