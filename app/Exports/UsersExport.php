<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with('GotRole', 'HasFaculty')->get();
    }

    /**
     * @param User $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->phone_no,
            $user->GotRole ? $user->GotRole->name : 'NULL',
            $user->HasFaculty ? $user->HasFaculty->title : 'NULL',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone No',
            'Role',
            'Faculty',
        ];
    }
}
