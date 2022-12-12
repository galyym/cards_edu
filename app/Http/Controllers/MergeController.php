<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class MergeController extends Controller
{

    public function merge(){

        Config::set('database.connections.kukadb', [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => '188.0.152.123',
                'port' => '37827',
                'database' => 'cards_log',
                'username' => '192.168.31.20',
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null
            ]);

        $id = 3;

        $query = DB::connection("kukadb")->table("cards_ready")
            ->select("*")
            ->where("mektep_id", "=", $id)
            ->where('status', '=', 'teacher')
            ->get();

        // дайын карталар базасында жатқан данныйлар
        $cards_ready_students = array();
        $count = 0;
        foreach ($query as $q) {
            $cards_ready_students[$count]["full_name"] = str_replace(array(" ", "\t", "\r", "\n"), "", $q->full_name);
            $cards_ready_students[$count]["id"] = $q->id;
            $cards_ready_students[$count]["iin"] = $q->iin;
            $count++;
        }

//        dd($cards_ready_students);


        // мектеп еду базасында жатқан данныйлар
        $getStudentFromMektepEdu= DB::table("mektep_teacher")
            ->select("*")
            ->where("id_mektep", "=", $id)
            ->get();

        $mektep_students_name = [];
        $c = 0;
        foreach ($getStudentFromMektepEdu as $item) {
            $full_name_stu = $item->surname."".$item->name;
            $mektep_students_name[$c]["full_name"] = str_replace(array(" ", "\t", "\r", "\n"), "", $full_name_stu);
            $mektep_students_name[$c]["student_id"] = $item->id;
            $mektep_students_name[$c]["iin"] = $item->iin;
            $c++;
        }

//        dd($mektep_students_name);

        $ready_full_name = [];
        foreach ($mektep_students_name as $m){
            for ($i = 0; $i < count($cards_ready_students); $i++){
                if ($m["full_name"] == $cards_ready_students[$i]["full_name"]){
//                if ($m["iin"] == $cards_ready_students[$i]["iin"]){
                    $ready_full_name[] = [
                        "mektepte_id" => $m["student_id"],
                        "mektepte_iin" => $m["iin"],
                        "mektepte_fullname" => $m["full_name"],
                        "cards_readyde_fullname" => $cards_ready_students[$i]["full_name"],
                        "cards_readyde_id" => $cards_ready_students[$i]["id"]
                    ];
                }

            }
        }

//        dd($ready_full_name);

        foreach ($ready_full_name as $item) {
            try {
                $sql = DB::connection("kukadb")->table("cards_ready")
                    ->where("id", "=", intval($item["cards_readyde_id"]))
                    ->where("mektep_id", "=", $id)
                    ->update([
                        "iin" => intval($item['mektepte_iin']),
                        "user_id" => intval($item["mektepte_id"])
                    ]);
            }catch (\Exception $e){
                dd($e);
            }
        }
        dd($sql);

        dd($ready_full_name);
    }
}
