<?php

namespace App\Repositories;

use App\Models\Receiver;

class ReceiverRepository implements ReceiverRepositoryInterface
{
    public function all($filters, $perPage)
    {
        $filterDefinitions = [
            'status' => '=',
            'name' => 'like',
            'pix_key_type' => '=',
            'pix_key' => 'like'
        ];

        $query = Receiver::query();
        $query = array_reduce(array_keys($filters), function ($query, $field) use ($filters, $filterDefinitions) {
            if (isset($filters[$field])) {
                $condition = $filterDefinitions[$field] === 'like' ? 'like' : '=';
                $value = $condition === 'like' ? '%' . $filters[$field] . '%' : $filters[$field];
                return $query->where($field, $condition, $value);
            }
            return $query;
        }, $query);

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return Receiver::create($data);
    }

    public function find($id)
    {
        return Receiver::find($id);
    }

    public function update($id, array $data)
    {
        $receiver = Receiver::find($id);
        if ($receiver) {
            $receiver->update($data);
            return $receiver;
        }
        return null;
    }

    public function delete($id)
    {
        $receiver = Receiver::find($id);
        if ($receiver) {
            $receiver->delete();
            return true;
        }
        return false;
    }

    public function deleteMany(array $ids)
    {
        return Receiver::whereIn('id', $ids)->delete();
    }
}