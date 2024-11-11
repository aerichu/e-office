<?php

namespace App\Controllers;
use App\Models\M_burger;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\Database\Config;

class Home extends BaseController
{
    public function dashboard()
    {
        if(session()->get('level')>0){ 
        echo view('header');
        echo view('menu');
        echo view('dashboard');
        }else{
        return redirect()->to('http://localhost:8080/home/login');
    }
    }
    public function login()
    {
        echo view('header');
        echo view('login');

    }

  public function aksi_login() {
    $u = $this->request->getPost('username');
    $p = $this->request->getPost('pw');

    // Inisialisasi model
    $model = new M_burger();

    // Mengatur kondisi pencarian
    $where = [
        'username' => $u,
        'pw' => md5($p)
    ];

    // Periksa apakah data user ditemukan
    $cek = $model->getWhereLogin('user', $where);

    if ($cek) {
        // Set session jika login berhasil
        session()->set('id', $cek->id_user);
        session()->set('username', $cek->username);
        session()->set('level', $cek->level);

        // Log aktivitas login
        // $model->logActivity($cek->id_user, 'login', 'User logged in.');

        return redirect()->to('home/dashboard');
    } else {
        // Redirect ke halaman login jika gagal
        return redirect()->to(base_url('home/login'));
    }
}

public function activity_log() {   
    if (session()->get('level') > 0) {
        $model = new M_burger();
        $logs = $model->getActivityLogs();
        $data['logs'] = $logs;

        $where = array(
            'id_toko' => 1
        );
        $setting = $model->getWhere('toko', $where);

        $data['setting'] = $setting ? $setting : []; // Jika setting kosong, set sebagai array kosong

        echo view('header');
        echo view('menu', $data);
        return view('activity_log', $data);
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}

public function logout() {
    $user_id = session()->get('id');
    
    if ($user_id) {
        // Log the logout activity
        $model = new M_burger();
        $model->logActivity($user_id, 'logout', 'User logged out.');
    }

    session()->destroy();
    return redirect()->to('http://localhost:8080/home/login');
}


public function user()
{
    if (session()->get('level')> 0) {
        $model = new M_burger();
        $data['jel'] = $model->tampil('user');
        
        $id = 1; // id_toko yang diinginkan

        // Menyusun kondisi untuk query
        $where = array('id_toko' => $id);

        // Mengambil data dari tabel 'toko' berdasarkan kondisi
        $data['user'] = $model->getWhere('toko', $where);

        // Memuat view
        // $data['setting'] = $model->getWhere('toko', $where);

        $user_id = session()->get('id');
        $model->logActivity($user_id, 'user', 'User in user page');

        echo view('header');
        echo view('menu', $data);
        echo view('user', $data);
    } else {
        return redirect()->to(base_url('home/login'));
    }
}

public function t_user()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('user');
    $model->logActivity($user_id, 'tambah user', 'User in tambah user page');
    echo view('header');
    echo view('menu', $data);
    echo view('t_user',$data);
}

public function aksi_t_user()
{
    $user_id = session()->get('id');
    $a = $this->request->getPost('username');
    $b = md5($this->request->getPost('pass'));
    $u = $this->request->getPost('level');

    // Prepare the data for inserting into the 'user' table
    $sis = array(
        'level' => $u,
        'username' => $a,
        'pw' => $b
    );

    // Instantiate the model and add the new user data
    $model = new M_burger;
    $model->tambah('user', $sis);

    $model->logActivity($user_id, 'user', 'User added a new account');  

    // Redirect the user after the operation is completed
    return redirect()->to('http://localhost:8080/home/user');
}

public function h_user($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_user' => $id);
    $model->hapus('user', $kil);
    $model->logActivity($id_user, 'user', 'User deleted a user data.');
    return redirect()->to(base_url('home/user'));
}

public function aksi_reset($id)
{
    $model = new M_burger();
    $user_id = session()->get('id');

    $where= array('id_user'=>$id);

    $isi = array(

        'pw' => md5('11111111')      

    );
    $model->editpw('user', $isi,$where);
    $model->logActivity($user_id, 'user', 'User reset a password');  

    return redirect()->to('home/user');
}

public function aksi_e_user()
{
    $model = new M_burger;
    $user_id = session()->get('id');
    $username = $this->request->getPost('username');
    $password = md5($this->request->getPost('pw'));  // Menggunakan md5 untuk hash password
    $level = $this->request->getPost('level');
    $id = $this->request->getPost('id_user');

    $where = ['id_user' => $id];
    $data = [
        'username' => $username,
        'pw' => $password,
        'level' => $level
    ];

    $model->edit('user', $data, $where);
    $model->logActivity($user_id, 'user', 'User updated a user data');

    return redirect()->to(base_url('home/user'))->with('success', 'User updated successfully');
}

public function register()
    {
        $model= new M_burger;
        $data['jel']= $model->tampil('user');
        echo view('header');
        echo view('register',$data);
    }
public function aksi_t_register()
    {
        $a= $this->request->getPost('nama');
        $b= md5($this->request->getPost('pass'));
        $sis= array(
            'level'=>'2',
            'username'=>$a,
            'pw'=>$b);
        $model= new M_burger;
        $model->tambah('user',$sis);
        return redirect()-> to ('http://localhost:8080/home/login');
    }

public function uploads()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('surat_masuk');
    $model->logActivity($user_id, 'surat masuk', 'User membuka salah satu surat masuk');
    echo view('header');
    echo view('menu', $data);
    echo view('uploads',$data);
}

public function restore()
{
    if (session()->get('level')>0) {
        $model= new M_burger;
        $user_id = session()->get('id');
        $data['jel']=$model->query('select * from surat_masuk where deleted_at IS NOT NULL');
        $model->logActivity($user_id, 'user', 'User in restore page');
        echo view('header');
        echo view('menu',$data);
        echo view('restore',$data);
    }else{
        return redirect()->to('http://localhost:8080/home/login');
    }
}
public function aksi_restore($id)
{
    $user_id = session()->get('id');
    $model = new M_burger();

    $where= array('id_sm'=>$id);
    $isi = array(
        'deleted_at'=>NULL
    );
    $model->edit('surat_masuk', $isi,$where);
    $model->logActivity($user_id, 'surat_masuk', 'User restore a data');  

    return redirect()->to('home/restore');
}
public function hapusproduk($id){
    $model = new M_burger();
    $id_user = session()->get('id'); // Ambil ID user dari session
    $activity = 'Menghapus produk'; // Deskripsi aktivitas
    $this->addLog($id_user, $activity);

    // Data yang akan diupdate untuk soft delete
    $data = [
        'isdelete' => 1,
        'deleted_by' => $id_user,
        'deleted_at' => date('Y-m-d H:i:s') // Format datetime untuk deleted_at
    ];

    // Update data produk dengan kondisi id_produk sesuai
    $model->logActivity($id_user, 'user', 'User deleted a surat masuk');
    $model->edit('surat_masuk', $data, ['id_sm' => $id]);

  return redirect()->to('home/surat_masuk');
}

public function surat_masuk()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    // $data['jel']= $model->tampil('surat_masuk');
    $data['jel']=$model->query('select * from surat_masuk  where deleted_at IS NULL');
    $model->logActivity($user_id, 'surat masuk', 'User in surat masuk page');
    echo view('header');
    echo view('menu', $data);
    echo view('surat_masuk',$data);
}

public function t_sm()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('surat_masuk');
    $model->logActivity($user_id, 'surat masuk', 'User in tambah surat masuk page');
    echo view('header');
    echo view('menu', $data);
    echo view('t_sm',$data);
}

public function aksi_t_sm()
{
    $user_id = session()->get('id');
    $b = $this->request->getPost('nomor_surat');
    $c = $this->request->getPost('tujuan');
    $d = $this->request->getPost('tanggal_terima');
    $e = $this->request->getPost('perihal');
    $f = $this->request->getPost('status');

    $uploadedFile = $this->request->getfile('file');
    $foto = $uploadedFile->getName();

    // Prepare the data for inserting into the 'surat_masuk' table
    $sis = array(
        'nomor_surat' => $b,
        'tujuan' => $c,
        'tanggal_terima' => $d,
        'perihal' => $e,
        'status' => $f,
        'file' => $foto // Save the filename if a file was uploaded
    );

    // Instantiate the model and add the new surat masuk data
    $model = new M_burger;
    $model->upload($uploadedFile);
    $model->tambah('surat_masuk', $sis);

    // Log the user activity
    $model->logActivity($user_id, 'surat masuk', 'User menambahkan surat masuk');  

    // Redirect the user after the operation is completed
    return redirect()->to('http://localhost:8080/home/surat_masuk');
}

// public function h_sm($id)
// {
//     $model = new M_burger();
//     $id_user = session()->get('id');
//     $kil = array('id_sm' => $id);
//     $model->hapus('surat_masuk', $kil);
//     $model->logActivity($id_user, 'surat masuk', 'User menghapus data surat masuk.');
//     return redirect()->to(base_url('home/surat_masuk'));
// }
public function h_sm($id)
{
    $model= new M_burger;
    $user_id = session()->get('id');
    $kil= array('id_sm'=>$id);
    $isi= array(
        'deleted_at'=>date('Y-m-d H:i:s'));
    $model->edit('surat_masuk',$isi,$kil);
    $model->logActivity($user_id, 'user', 'User deleted a surat_masuk');
    // $model->hapus('makanan',$kil);
    return redirect()-> to('http://localhost:8080/home/surat_masuk');
}

public function aksi_e_sm()
{
    $model = new M_burger;
    $user_id = session()->get('id');
    $b = $this->request->getPost('nomor_surat');
    $c = $this->request->getPost('tujuan');
    $d = $this->request->getPost('tanggal_terima');
    $e = $this->request->getPost('perihal');
    $f = $this->request->getPost('status');
    $id = $this->request->getPost('id_sm');

    $uploadedFile = $this->request->getFile('file');
    $existingFile = $this->request->getPost('existing_file'); // Get the existing file name

    // If a new file is uploaded, process it
    if ($uploadedFile && $uploadedFile->isValid()) {
        // If there's an existing file, delete it first
        if ($existingFile && file_exists(ROOTPATH . 'public/img/' . $existingFile)) {
            unlink(ROOTPATH . 'public/img/' . $existingFile);
        }

        // Move the new file to the img folder
        $newFileName = $uploadedFile->getName();
        $uploadedFile->move(ROOTPATH . 'public/img', $newFileName);

        // Update the data with the new file name
        $fileData = ['file' => $newFileName];
    } else {
        // If no file is uploaded, retain the existing file name
        $fileData = ['file' => $existingFile];
    }

    // Prepare the other data for updating
    $data = [
        'nomor_surat' => $b,
        'tujuan' => $c,
        'tanggal_terima' => $d,
        'perihal' => $e,
        'status' => $f
    ];

    // Merge the file data with the other data
    $data = array_merge($data, $fileData);

    // Update the record in the database
    $where = ['id_sm' => $id];
    $model->editgambar('surat_masuk', $data, $where);
    
    // Log the activity
    $model->logActivity($user_id, 'user', 'User telah memperbarui data surat masuk');

    // Redirect with success message
    return redirect()->to(base_url('home/surat_masuk'))->with('success', 'Surat masuk updated successfully');
}


public function printFile($id_sm)
{
    // Manually load the database service
    $db = Config::connect()->table('surat_masuk'); // Explicitly connect and set the table
    
    // Get the file record based on id_sm
    $fileData = $db->where('id_sm', $id_sm)->get()->getRow();

    if ($fileData && !empty($fileData->file)) {
        // File exists in the database
        $fileName = $fileData->file;
        $filePath = ROOTPATH . 'public/img/' . $fileName;

        // Check if the file exists in the file system
        if (file_exists($filePath)) {
            // Force the file to be downloaded
            return $this->response->download($filePath, null)->setFileName($fileName);
        } else {
            // If file doesn't exist on the server
            return redirect()->to(base_url('home/surat_masuk'))->with('error', 'File not found on server!');
        }
    } else {
        // If file doesn't exist in the database
        return redirect()->to(base_url('home/surat_masuk'))->with('error', 'File not found in database!');
    }
}



public function surat_keluar()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    // $data['jel']= $model->tampil('surat_keluar');
    $data['jel']=$model->query('select * from surat_keluar  where deleted_at IS NULL');
    $model->logActivity($user_id, 'surat keluar', 'User berada di halaman surat keluar');
    echo view('header');
    echo view('menu', $data);
    echo view('surat_keluar',$data);
}

// public function h_sk($id)
// {
//     $model = new M_burger();
//     $id_user = session()->get('id');
//     $kil = array('id_sk' => $id);
//     $model->hapus('surat_keluar', $kil);
//     $model->logActivity($id_user, 'surat keluar', 'User menghapus data surat keluar.');
//     return redirect()->to(base_url('home/surat_keluar'));
// }
public function h_sk($id)
{
    $model= new M_burger;
    $user_id = session()->get('id');
    $kil= array('id_sk'=>$id);
    $isi= array(
        'deleted_at'=>date('Y-m-d H:i:s'));
    $model->edit('surat_keluar',$isi,$kil);
    $model->logActivity($user_id, 'user', 'User deleted a surat_keluar');
    // $model->hapus('makanan',$kil);
    return redirect()-> to('http://localhost:8080/home/surat_keluar');
}
public function hapusproduk1($id){
    $model = new M_burger();
    $id_user = session()->get('id'); // Ambil ID user dari session
    $activity = 'Menghapus produk'; // Deskripsi aktivitas
    $this->addLog($id_user, $activity);

    // Data yang akan diupdate untuk soft delete
    $data = [
        'isdelete' => 1,
        'deleted_by' => $id_user,
        'deleted_at' => date('Y-m-d H:i:s') // Format datetime untuk deleted_at
    ];

    // Update data produk dengan kondisi id_produk sesuai
    $model->logActivity($id_user, 'user', 'User deleted a surat keluar');
    $model->edit('surat_keluar', $data, ['id_sk' => $id]);

  return redirect()->to('home/surat_keluar');
}
public function restore1()
{
    if (session()->get('level')>0) {
        $model= new M_burger;
        $user_id = session()->get('id');
        $data['jel']=$model->query('select * from surat_keluar where deleted_at IS NOT NULL');
        $model->logActivity($user_id, 'user', 'User in restore page');
        echo view('header');
        echo view('menu',$data);
        echo view('restore1',$data);
    }else{
        return redirect()->to('http://localhost:8080/home/login');
    }
}
public function aksi_restore1($id)
{
    $user_id = session()->get('id');
    $model = new M_burger();

    $where= array('id_sk'=>$id);
    $isi = array(
        'deleted_at'=>NULL
    );
    $model->edit('surat_keluar', $isi,$where);
    $model->logActivity($user_id, 'surat_keluar', 'User restore a data');  

    return redirect()->to('home/restore1');
}

public function t_sk()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('surat_keluar');
    $model->logActivity($user_id, 'surat keluar', 'User in tambah surat keluar page');
    echo view('header');
    echo view('menu', $data);
    echo view('t_sk',$data);
}

public function aksi_t_sk()
{
    $user_id = session()->get('id');
    $a = $this->request->getPost('nomor_surat');
    $x = $this->request->getPost('email');
    $b = $this->request->getPost('perihal');
    $c = $this->request->getPost('tujuan');
    $d = $this->request->getPost('tanggal_kirim');
    $e = $this->request->getPost('status');

    $uploadedFile = $this->request->getfile('file');
    $foto = $uploadedFile->getName();

    // Prepare the data for inserting into the 'surat_masuk' table
    $sis = array(
        'nomor_surat' => $a,
        'email' => $x,
        'perihal' => $b,
        'tujuan' => $c,
        'tanggal_kirim' => $d,
        'status' => $e,
        'file' => $foto // Save the filename if a file was uploaded
    );

    // Instantiate the model and add the new surat masuk data
    $model = new M_burger;
    $model->upload($uploadedFile);
    $model->tambah('surat_keluar', $sis);

    // Log the user activity
    $model->logActivity($user_id, 'surat keluar', 'User menambahkan surat keluar');  

    // Redirect the user after the operation is completed
    return redirect()->to('http://localhost:8080/home/surat_keluar');
}


public function aksi_e_sk($id_sk)
{
    $model = new M_burger(); // Instantiate the model
    $table = 'surat_keluar';

    // Collect form data
    $data = [
        'nomor_surat' => $this->request->getPost('nomor_surat'),
        'email' => $this->request->getPost('email'),
        'perihal' => $this->request->getPost('perihal'),
        'tujuan' => $this->request->getPost('tujuan'),
        'tanggal_kirim' => $this->request->getPost('tanggal_kirim'),
        'status' => $this->request->getPost('status')
    ];

    // Check if a new file is uploaded
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Upload new file
        $model->upload($file);
        
        // Update data array with the new file name
        $data['file'] = $file->getName();
    } else {
        // Retain the existing file if no new file is uploaded
        $data['file'] = $this->request->getPost('existing_file');
    }

    // Define where condition
    $where = ['id_sk' => $id_sk];

    // Update record in database
    $model->edit($table, $data, $where);

    // Redirect to the main page with a success message
    return redirect()->to(base_url('home/surat_keluar'))->with('message', 'Data updated successfully.');
}

public function printFileKeluar($id_sk)
{
    // Manually load the database service
    $db = Config::connect()->table('surat_keluar'); // Explicitly connect and set the table
    
    // Get the file record based on id_sm
    $fileData = $db->where('id_sk', $id_sk)->get()->getRow();

    if ($fileData && !empty($fileData->file)) {
        // File exists in the database
        $fileName = $fileData->file;
        $filePath = ROOTPATH . 'public/img/' . $fileName;

        // Check if the file exists in the file system
        if (file_exists($filePath)) {
            // Force the file to be downloaded
            return $this->response->download($filePath, null)->setFileName($fileName);
        } else {
            // If file doesn't exist on the server
            return redirect()->to(base_url('home/surat_keluar'))->with('error', 'File not found on server!');
        }
    } else {
        // If file doesn't exist in the database
        return redirect()->to(base_url('home/surat_keluar'))->with('error', 'File not found in database!');
    }
}



public function hrd()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('cuti');
    $data['aria']= $model->tampil('lamar');
    $model->logActivity($user_id, 'section hrd', 'User berada di halaman hrd');
    echo view('header');
    echo view('menu', $data);
    echo view('hrd',$data);
}

public function t_cuti()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('cuti');
    $model->logActivity($user_id, 'cuti', 'User berada di halaman tambah surat pengajuan cuti');
    echo view('header');
    echo view('menu', $data);
    echo view('t_cuti',$data);
}

public function aksi_t_cuti()
{
    $user_id = session()->get('id');
    $uploadedFile = $this->request->getfile('file');
    $foto = $uploadedFile->getName();
    $a = $this->request->getPost('nama');

    // Prepare the data for inserting into the 'cuti' table, including the current datetime
    $sis = array(
        'file' => $foto,
        'nama' => $a, 
        'tanggal' => date('Y-m-d H:i:s') // Set the current datetime
    );

    // Instantiate the model and add the new cuti data
    $model = new M_burger;
    $model->upload($uploadedFile);
    $model->tambah('cuti', $sis);

    // Log the user activity
    $model->logActivity($user_id, 'cuti', 'User menambahkan surat pengajuan cuti');  

    // Redirect the user after the operation is completed
    return redirect()->to('http://localhost:8080/home/hrd');
}

public function printFileCuti($id_cuti)
{
    // Manually load the database service
    $db = Config::connect()->table('cuti'); // Explicitly connect and set the table
    
    // Get the file record based on id_sm
    $fileData = $db->where('id_cuti', $id_cuti)->get()->getRow();

    if ($fileData && !empty($fileData->file)) {
        // File exists in the database
        $fileName = $fileData->file;
        $filePath = ROOTPATH . 'public/img/' . $fileName;

        // Check if the file exists in the file system
        if (file_exists($filePath)) {
            // Force the file to be downloaded
            return $this->response->download($filePath, null)->setFileName($fileName);
        } else {
            // If file doesn't exist on the server
            return redirect()->to(base_url('home/hrd'))->with('error', 'File not found on server!');
        }
    } else {
        // If file doesn't exist in the database
        return redirect()->to(base_url('home/hrd'))->with('error', 'File not found in database!');
    }
}

public function h_cuti($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_cuti' => $id);
    $model->hapus('cuti', $kil);
    $model->logActivity($id_user, 'cuti', 'User menghapus surat cuti.');
    return redirect()->to(base_url('home/hrd'));
}

public function aksi_e_cuti($id)
{
    $model = new M_burger();
    $uploadedFile = $this->request->getFile('file');
    $currentDateTime = date('Y-m-d H:i:s'); // Mengambil tanggal dan waktu saat ini
    $nama = $this->request->getPost('nama');

    // Prepare data for updating the record
    if ($uploadedFile && $uploadedFile->isValid()) {
        // Jika file baru diunggah, simpan file dan perbarui nama file
        $model->upload($uploadedFile);
        $data = [
            'file' => $uploadedFile->getName(),
            'nama' => $nama, 
            'tanggal' => $currentDateTime // Update datetime
        ];

        // Gunakan method editgambar untuk memperbarui data dengan file baru
        $model->editgambar('cuti', $data, ['id_cuti' => $id]);
    } else {
        // Jika tidak ada file baru diunggah, perbarui nama dan tanggal saja
        $data = [
            'nama' => $nama,
            'tanggal' => $currentDateTime // Update datetime
        ];

        // Gunakan method edit untuk memperbarui data tanpa mengubah file
        $model->edit('cuti', $data, ['id_cuti' => $id]);
    }

    // Redirect kembali ke halaman HRD setelah memperbarui data
    return redirect()->to(base_url('home/hrd'));
}

public function t_lamar()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('lamar');
    $model->logActivity($user_id, 'lamar', 'User berada di halaman tambah surat pengajuan lamaran');
    echo view('header');
    echo view('menu', $data);
    echo view('t_lamar',$data);
}

public function aksi_t_lamar()
{
    $model = new M_burger(); // Instantiate the M_burger model
    $user_id = session()->get('id');

    // Gather form data
    $data = [
        'nama_pelamar' => $this->request->getPost('nama_pelamar'),
        'posisi' => $this->request->getPost('posisi'),
        'pendidikan' => $this->request->getPost('pendidikan'),
        'pengalaman_kerja' => $this->request->getPost('pengalaman_kerja'),
        'tanggal_melamar' => $this->request->getPost('tanggal_melamar'),
        'status' => $this->request->getPost('status'),
    ];

    // Handle file upload
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Generate a random file name
        $fileName = $file->getRandomName();

        // Move the file to the public/img directory
        $filePath = ROOTPATH . 'public/img/' . $fileName; // Save to public/img

        // Check if file move is successful
        if ($file->move(ROOTPATH . 'public/img', $fileName)) {
            $data['file'] = $fileName; // Store the file name in the data array
        } else {
            // Log or handle the error if file upload fails
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/hrd'))->with('error', 'File upload failed.');
        }
    }

    // Insert data into the 'lamar' table using the tambah method
    $model->tambah('lamar', $data);
    $model->logActivity($user_id, 'lamar', 'User menambahkan data surat lamaran');

    // Redirect with a success message
    return redirect()->to(base_url('home/hrd'))->with('success', 'Lamaran berhasil ditambahkan');
}

public function h_lamar($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_lamar' => $id);
    $model->hapus('lamar', $kil);
    $model->logActivity($id_user, 'cuti', 'User menghapus surat lamar.');
    return redirect()->to(base_url('home/hrd'));
}

public function aksi_e_lamar()
{
    // Get the ID from the hidden input field
    $id_lamar = $this->request->getPost('id_lamar');
    $id_user = session()->get('id');

    // Gather the form data
    $data = [
        'nama_pelamar' => $this->request->getPost('nama_pelamar'),
        'posisi' => $this->request->getPost('posisi'),
        'pendidikan' => $this->request->getPost('pendidikan'),
        'pengalaman_kerja' => $this->request->getPost('pengalaman_kerja'),
        'tanggal_melamar' => $this->request->getPost('tanggal_melamar'),
        'status' => $this->request->getPost('status')
    ];

    // Handle the file upload (if any)
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        $fileName = $file->getRandomName(); // Generate a random file name
        $file->move(WRITEPATH . 'uploads', $fileName); // Save the file

        // Add the new file to the data array
        $data['file'] = $fileName;
    } else {
        // If no new file was uploaded, check for an existing file
        $existing_file = $this->request->getPost('existing_file');
        if ($existing_file) {
            $data['file'] = $existing_file;
        }
    }

    // Use the model to update the record
    $model = new M_burger();
    $where = ['id_lamar' => $id_lamar];

    $model->logActivity($id_user, 'lamaran', 'User mengupdate data surat lamar.');
    // Update the database record
    $model->editgambar('lamar', $data, $where);

    // Redirect with a success message
    return redirect()->to(base_url('home/hrd'))->with('success', 'Lamaran berhasil diperbarui');
}



public function administrasi()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('administrasi');
    $model->logActivity($user_id, 'administrasi', 'User berada di halaman administrasi');
    echo view('header');
    echo view('menu', $data);
    echo view('administrasi',$data);
}

public function h_admin($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_admin' => $id);
    $model->hapus('administrasi', $kil);
    $model->logActivity($id_user, 'cuti', 'User menghapus surat pembayaran.');
    return redirect()->to(base_url('home/administrasi'));
}

public function t_admin()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('administrasi');
    $model->logActivity($user_id, 'administrasi', 'User berada di halaman tambah surat pembayaran');
    echo view('header');
    echo view('menu', $data);
    echo view('t_admin',$data);
}

public function aksi_t_admin()
{
    // Load model M_burger
    $model = new M_burger();

    // Data dari form
    $data = [
        'asal_surat' => $this->request->getPost('asal_surat'),
        'tanggal_surat' => $this->request->getPost('tanggal_surat'),
        'tujuan' => $this->request->getPost('tujuan')
    ];

    // Handle file upload
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Generate a random file name
        $fileName = $file->getRandomName();

        // Move the file to the public/img directory
        $filePath = ROOTPATH . 'public/img/' . $fileName; // Save to public/img

        // Check if file move is successful
        if ($file->move(ROOTPATH . 'public/img', $fileName)) {
            $data['file'] = $fileName; // Store the file name in the data array
        } else {
            // Log or handle the error if file upload fails
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/administrasi'))->with('error', 'File upload failed.');
        }
    }

    // Simpan data ke tabel administrasi menggunakan metode tambah
    $model->tambah('administrasi', $data);

    // Redirect kembali ke halaman utama dengan pesan sukses
    return redirect()->to(base_url('home/administrasi'))->with('success', 'Data administrasi berhasil ditambahkan.');
}

public function aksi_e_admin()
{
    $id_admin = $this->request->getPost('id_admin');
    $id_user = session()->get('id');

    $data = [
        'asal_surat' => $this->request->getPost('asal_surat'),
        'tanggal_surat' => $this->request->getPost('tanggal_surat'),
        'tujuan' => $this->request->getPost('tujuan'),
    ];

    // Handle the file upload (if any)
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Use the original file name
        $fileName = $file->getName();

        // Move the file to 'public/img' with the original file name
        if ($file->move(ROOTPATH . 'public/img', $fileName, true)) {
            $data['file'] = $fileName; // Store the original file name
        } else {
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/administrasi'))->with('error', 'File upload failed.');
        }
    } else {
        // Retain the existing file if no new file is uploaded
        $data['file'] = $this->request->getPost('existing_file');
    }

    // Update the record in the database
    $model = new M_burger();
    $where = ['id_admin' => $id_admin];
    $model->logActivity($id_user, 'administrasi', 'User mengupdate data pembayaran.');
    $model->editgambar('administrasi', $data, $where);

    return redirect()->to(base_url('home/administrasi'))->with('success', 'Lamaran berhasil diperbarui');
}














public function kesiswaan()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('raport');
    $data['jel2']= $model->tampil('alumni');
    $model->logActivity($user_id, 'kesiswaan', 'User berada di halaman kesiswaan');
    echo view('header');
    echo view('menu', $data);
    echo view('kesiswaan',$data);
}

public function t_raport()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('raport');
    $model->logActivity($user_id, 'raport', 'User berada di halaman tambah file raport');
    echo view('header');
    echo view('menu', $data);
    echo view('t_raport',$data);
}

public function aksi_t_raport()
{
    // Load model M_burger
    $model = new M_burger();

    // Data dari form
    $data = [
        'nis_siswa' => $this->request->getPost('nis_siswa'),
        'kelas' => $this->request->getPost('kelas'),
        'blok' => $this->request->getPost('blok'),
        'semester' => $this->request->getPost('semester'),
        'nilai_keseluruhan' => $this->request->getPost('nilai_keseluruhan'),
        'nilai_ekstrakurikuler' => $this->request->getPost('nilai_ekstrakurikuler')
    ];

    // Handle file upload
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Generate a random file name
        $fileName = $file->getRandomName();

        // Move the file to the public/img directory
        $filePath = ROOTPATH . 'public/img/' . $fileName; // Save to public/img

        // Check if file move is successful
        if ($file->move(ROOTPATH . 'public/img', $fileName)) {
            $data['file'] = $fileName; // Store the file name in the data array
        } else {
            // Log or handle the error if file upload fails
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/administrasi'))->with('error', 'File upload failed.');
        }
    }

    // Simpan data ke tabel administrasi menggunakan metode tambah
    $model->tambah('raport', $data);

    // Redirect kembali ke halaman utama dengan pesan sukses
    return redirect()->to(base_url('home/kesiswaan'))->with('success', 'Data administrasi berhasil ditambahkan.');
}

public function h_raport($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_raport' => $id);
    $model->hapus('raport', $kil);
    $model->logActivity($id_user, 'cuti', 'User menghapus data raport.');
    return redirect()->to(base_url('home/kesiswaan'));
}

public function aksi_e_raport()
{
    $id_raport = $this->request->getPost('id_raport');
    $id_user = session()->get('id');

    // Gather data from the form
    $data = [
        'nis_siswa' => $this->request->getPost('nis_siswa'),
        'kelas' => $this->request->getPost('kelas'),
        'blok' => $this->request->getPost('blok'),
        'semester' => $this->request->getPost('semester'),
        'nilai_keseluruhan' => $this->request->getPost('nilai_keseluruhan'),
        'nilai_ekstrakurikuler' => $this->request->getPost('nilai_ekstrakurikuler')
    ];

    // Handle the file upload (if any)
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Use the original file name
        $fileName = $file->getName();

        // Move the file to 'public/img' with the original file name
        if ($file->move(ROOTPATH . 'public/img', $fileName, true)) {
            $data['file'] = $fileName; // Store the original file name
        } else {
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File upload failed.');
        }
    } else {
        // If no new file is uploaded, keep the existing file
        $existingFile = $this->request->getPost('existing_file');
        if ($existingFile) {
            $data['file'] = $existingFile; // Retain the existing file name
        }
    }

    // Update the record in the database
    $model = new M_burger();
    $where = ['id_raport' => $id_raport];
    $model->logActivity($id_user, 'kesiswaan', 'User mengupdate data raport.');
    $model->editgambar('raport', $data, $where);

    return redirect()->to(base_url('home/kesiswaan'))->with('success', 'Lamaran berhasil diperbarui');
}

public function t_alumni()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('alumni');
    $model->logActivity($user_id, 'alumni', 'User berada di halaman tambah dokumen alumni');
    echo view('header');
    echo view('menu', $data);
    echo view('t_alumni',$data);
}

public function aksi_t_alumni()
{
    // Load model M_burger
    $model = new M_burger();

    // Data dari form
    $data = [
        'nis_alumni' => $this->request->getPost('nis_alumni'),
        'tahun_lulus' => $this->request->getPost('tahun_lulus'),
        'jurusan' => $this->request->getPost('jurusan'),
        'ipk' => $this->request->getPost('ipk')
    ];

    // Handle file upload
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        // Generate a random file name
        $fileName = $file->getRandomName();

        // Move the file to the public/img directory
        $filePath = ROOTPATH . 'public/img/' . $fileName; // Save to public/img

        // Check if file move is successful
        if ($file->move(ROOTPATH . 'public/img', $fileName)) {
            $data['file'] = $fileName; // Store the file name in the data array
        } else {
            // Log or handle the error if file upload fails
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File upload failed.');
        }
    }

    // Simpan data ke tabel alumni menggunakan metode tambah
    $model->tambah('alumni', $data);

    // Redirect kembali ke halaman utama dengan pesan sukses
    return redirect()->to(base_url('home/kesiswaan'))->with('success', 'Data alumni berhasil ditambahkan.');
}

public function h_alumni($id)
{
    $model = new M_burger();
    $id_user = session()->get('id');
    $kil = array('id_alumni' => $id);
    $model->hapus('alumni', $kil);
    $model->logActivity($id_user, 'alumni', 'User menghapus data alumni.');
    return redirect()->to(base_url('home/kesiswaan'));
}

public function aksi_e_alumni()
{
    $id_alumni = $this->request->getPost('id_alumni');
    $id_user = session()->get('id');

    // Prepare data for updating
    $data = [
        'nis_alumni' => $this->request->getPost('nis_alumni'),
        'tahun_lulus' => $this->request->getPost('tahun_lulus'), // Ensure correct date format
        'jurusan' => $this->request->getPost('jurusan'),
        'ipk' => $this->request->getPost('ipk')
    ];

    // Handle the file upload
    $file = $this->request->getFile('file');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        // Use original filename
        $fileName = $file->getName();

        // Move file to 'public/img'
        if ($file->move(ROOTPATH . 'public/img', $fileName, true)) {
            $data['file'] = $fileName; // Update 'file' field with new file name
        } else {
            log_message('error', 'File upload failed.');
            return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File upload failed.');
        }
    } else {
        // Keep the existing file if no new file is uploaded
        $data['file'] = $this->request->getPost('existing_file');
    }

    // Update record in the database
    $model = new M_burger();
    $where = ['id_alumni' => $id_alumni];
    $model->logActivity($id_user, 'kesiswaan', 'User updated alumni data.');
    $model->editgambar('alumni', $data, $where);

    return redirect()->to(base_url('home/kesiswaan'))->with('success', 'Alumni data successfully updated');
}

public function printFileRaport($id_raport)
{
    // Manually load the database service
    $db = Config::connect()->table('raport'); // Explicitly connect and set the table
    
    // Get the file record based on id_sm
    $fileData = $db->where('id_raport', $id_raport)->get()->getRow();

    if ($fileData && !empty($fileData->file)) {
        // File exists in the database
        $fileName = $fileData->file;
        $filePath = ROOTPATH . 'public/img/' . $fileName;

        // Check if the file exists in the file system
        if (file_exists($filePath)) {
            // Force the file to be downloaded
            return $this->response->download($filePath, null)->setFileName($fileName);
        } else {
            // If file doesn't exist on the server
            return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File not found on server!');
        }
    } else {
        // If file doesn't exist in the database
        return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File not found in database!');
    }
}

public function printFileAlumni($id_alumni)
{
    // Manually load the database service
    $db = Config::connect()->table('alumni'); // Explicitly connect and set the table
    
    // Get the file record based on id_sm
    $fileData = $db->where('id_alumni', $id_alumni)->get()->getRow();

    if ($fileData && !empty($fileData->file)) {
        // File exists in the database
        $fileName = $fileData->file;
        $filePath = ROOTPATH . 'public/img/' . $fileName;

        // Check if the file exists in the file system
        if (file_exists($filePath)) {
            // Force the file to be downloaded
            return $this->response->download($filePath, null)->setFileName($fileName);
        } else {
            // If file doesn't exist on the server
            return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File not found on server!');
        }
    } else {
        // If file doesn't exist in the database
        return redirect()->to(base_url('home/kesiswaan'))->with('error', 'File not found in database!');
    }
}






public function folder()
{
    $model= new M_burger;
    $user_id = session()->get('id');
    
    $data['jel']= $model->tampil('folder');
    $model->logActivity($user_id, 'folder', 'User in folder page');
    echo view('header');
    echo view('menu', $data);
    echo view('folder',$data);
}













//laporan
public function laporan()
{
    if (session()->get('level')>0) {
        $model = new M_burger();
        $user_id = session()->get('id');
             $model->logActivity($user_id, 'laporan', 'User in laporan');
             echo view('header');
             echo view('menu');
             echo view('laporan');
         } else {
            return redirect()->to('http://localhost:8080/home/login');
        }
    }

    public function generate_report()
{
    if (session()->get('level') > 0) {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $report_type = $this->request->getPost('report_type');

        switch ($report_type) {
            case 'pdf':
                $this->generate_pdf($start_date, $end_date);
                break;
            case 'excel':
                $this->generate_excel($start_date, $end_date);
                break;
            case 'window':
                $this->generate_window_result($start_date, $end_date);
                break;
            default:
                return redirect()->to('home/error');
        }
    } else {
        return redirect()->to('home/login');
    }
}


    private function generate_pdf($start_date, $end_date)
{
    $model = new M_burger();
    $data['laporan'] = $model->getLaporanByDate($start_date, $end_date);

    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);
    $html = view('laporan_pdf', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("laporan.pdf", array("Attachment" => false));
}

private function generate_excel($start_date, $end_date)
{
    $model = new M_burger();
    $data['laporan'] = $model->getLaporanByDateForExcel($start_date, $end_date);

    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()->setCreator("Your Name")->setLastModifiedBy("Your Name")
        ->setTitle("Laporan Loker")->setSubject("Laporan Loker")
        ->setDescription("Laporan Transaksi")->setKeywords("Spreadsheet")
        ->setCategory("Report");

    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'tanggal terima')
        ->setCellValue('B1', 'nomor surat')
        ->setCellValue('C1', 'status')
        ->setCellValue('D1', 'perihal')
        ->setCellValue('E1', 'tujuan')
        ->setCellValue('F1', 'email');

    $rowCount = 2;
    foreach ($data['laporan'] as $row) {
        $sheet->setCellValue('A' . $rowCount, $row['tanggal_terima'])
            ->setCellValue('B' . $rowCount, $row['nomor_surat'])
            ->setCellValue('C' . $rowCount, $row['status'])
            ->setCellValue('D' . $rowCount, $row['perihal'])
            ->setCellValue('E' . $rowCount, $row['tujuan'])
            ->setCellValue('F' . $rowCount, $row['email']);
        $rowCount++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}

private function generate_window_result($start_date, $end_date)
{
    $model = new M_burger();
    $data['formulir'] = $model->getLaporanByDate($start_date, $end_date);
    echo view('cetak_hasil', $data);
}


}
