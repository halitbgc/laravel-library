<?
namespace App\Services;


use App\Models\User;
use \Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
class UserService
{

    public function countUsers(): int
    {
        return User::count();
    }
    public function getAllUsers(): Collection
    {
        return User::select('id', 'name', 'surname', 'created_at')->get();
    }

    public function getAllEmployees(): Collection
    {
        return User::role('employee', )->select('id', 'name', 'email','surname', 'created_at')->get();
    }
    public function getAllVisitors(): Collection
    {
        return User::role('visitor')
            ->select('id', 'name', 'surname', 'email', 'created_at')
            ->get();
    }
}