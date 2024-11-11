<?php

namespace App\Models;
use CodeIgniter\Model;

class M_burger extends Model
{

protected $table = 'surat_masuk';  // Specify the table
protected $primaryKey = 'id_sm';   // Specify the primary key
	
public function getWhere($table, $where) {
    $query = $this->db->table($table)->getWhere($where);
    if ($query && $query->getNumRows() > 0) {
        return $query->getRowArray(); // Kembalikan data dalam bentuk array
    }
    return null; // Jika tidak ada data, kembalikan null
}
public function getWhereLogin($table, $where) {
    return $this->db->table($table)
                    ->where($where)
                    ->get()
                    ->getRow();
}
public function getActivityLogs() {
    $query = $this->db->table('activity_logs')
                      ->join('user', 'activity_logs.user_id = user.id_user', 'left')
                      ->select('user.username, activity_logs.activity, activity_logs.description, activity_logs.timestamp')
                      ->orderBy('activity_logs.timestamp', 'DESC')
                      ->get();

    return $query->getResultArray(); // Kembalikan data sebagai array untuk iterasi di view
}
public function logActivity($user_id, $activity, $description) {
    // Pastikan tabel yang akan di-insert ada
    if (!empty($user_id) && !empty($activity)) {
        $data = [
            'user_id' => $user_id,
            'activity' => $activity,
            'description' => $description,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        // Menyimpan data ke dalam tabel activity_logs
        $this->db->table('activity_logs')->insert($data);
    }
}
public function tampil($org)
    {
        return $this->db->table($org)->get()->getResult();
    }

public function tambah($table,$where)
    {
        return $this->db->table($table)->insert($where);
    }
public function hapus($kolom,$where)
    {
        return $this->db->table($kolom)->delete($where);
    }
public function editpw($table, $data, $where)
    {
        return $this->db->table($table)->update($data, $where);
    }
public function edit($kin,$isi,$where)
    {
        return $this->db->table($kin)->update($isi,$where);
    }
 public function upload($file)
    {
        $imageName = $file->getName();
        $file->move(ROOTPATH.'public/img',$imageName);
    }

public function upload1($file)
{
    $imageName = $file->getName();
    $file->move(ROOTPATH . 'public/img', $imageName);  // Ensure the file moves to the 'public/img' directory
}

public function editgambar($table, $data, $where)
{
    return $this->db->table($table)->update($data, $where);
}
public function query($query)
{
    return $this->db->query($query)
                    ->getResult();
}
public function getLaporanByDate($start_date, $end_date)
{
    return $this->db->table('surat_masuk')
    ->where('tanggal_terima >=', $start_date)
    ->where('tanggal_terima <=', $end_date)
    ->get()
    ->getResult();
}

public function getLaporanByDateForExcel($start_date, $end_date)
{
    $query = $this->db->table('surat_masuk')
    ->where('tanggal_terima >=', $start_date)
    ->where('tanggal_terima <=', $end_date)
    ->get();

    return $query->getResultArray();
}

}
?>