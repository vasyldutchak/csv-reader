<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CsvData extends Model
{

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $table = 'csv_datas';

    protected $fillable = [
        'uid',
        'firstname',
        'lastname',
        'birthday',
        'datechange',
        'description'
    ];


    /**
     * saveData - зберігаємо дані в БД
     *
     * @param array $data
     *
     * @return array
     */
    public function saveData(array $data): array
    {
        $updated = 0;

        $created = 0;


        $uid = array_get($data, 'uid');

        $currentUids = $this->select('uid')->get()->pluck('uid');


//        $emptyData = array_except('uid');
//        dd($emptyData);

        $item = CsvData::find($uid);

        if ($item !== null) {

            $exist = CsvData::where('uid', $data['uid'])->where('datechange', $data['datechange'])->get();

            // Якщо змінилося поле dateChange то дані мають бути обновлені
            if ($exist->isEmpty()) {

                $item->update($data);
                $updated += 1;

            }

        } else {

            // Підчас аплоаду дані з файла яких нема в таблиці повинні бути додані.
            $this->create($data);
            $created += 1;

        }

        return compact('updated', 'created');

    }

    /**
     * deleteAll - очищаємо БД
     *
     * @return mixed
     */
    public function deleteAll()
    {
        return $this->query()->delete();
    }


}
