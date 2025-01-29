<?php

namespace Models;

class Permission extends Model
{

    public int $id;
    public string $permissionName;

    /**
     * @param int $id
     * @param string $permissionName
     */
    public function __construct(int $id, string $permissionName)
    {
        $this->id = $id;
        $this->permissionName = $permissionName;
    }

    public static function fromData(array $data): static{
        return new static(
            $data['id'],
            $data['permission_name']
        );
    }

    public function toApiResponse(array $with = []): array
    {
        return array_merge([
            'id' => $this->id,
            'permissionName' => $this->permissionName
        ], $with );
    }

}