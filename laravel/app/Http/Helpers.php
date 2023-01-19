<?php

namespace App\Http;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Contact;

class Helpers
{
    protected $types;
    protected $status;
    protected $rating;
    protected $target;
    protected $colors;
    protected $smtpSecure;
    protected $extensions;
    protected $characters;
    protected $contactSubject;

    public function __construct()
    {
        $this->types = [
            //! 'administrator,admin,user,editor,author'
            'administrator' => 'Teknik Destek',
            'admin' => 'Yönetici',
            'user' => 'Kullanıcı',
            'demo' => 'Demo Hesabı',
            //'editor' => 'Editör',
            //'author' => 'Yazar',
        ];

        $this->status = [
            //! 'active', 'passive', 'deleted', 'blocked', 'pending', 'suspended', 'banned', 'draft', 'published', 'archived'
            'active' => 'Aktif',
            'passive' => 'Pasif',
            //'deleted' => 'Silinmiş',
            //'blocked' => 'Engellenmiş',
            //'pending' => 'Beklemede',
            //'suspended' => 'Askıya Alınmış',
            //'banned' => 'Yasaklı',
            //'draft' => 'Taslak',
            //'published' => 'Yayınlanmış',
            //'archived' => 'Arşivlenmiş',
        ];

        $this->rating = [
            //! 'excellent', 'good', 'average', 'bad', 'terrible'
            'excellent' => 'Mükemmel',
            'good' => 'İyi',
            'average' => 'Orta',
            'bad' => 'Kötü',
            'terrible' => 'Berbat',
        ];

        $this->target = [
            //! '_blank', '_self'
            '_self' => 'Kendi Sayfasında Aç',
            '_blank' => 'Yeni Sekmede Aç',
        ];

        $this->colors = [
            //! 'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'
            'primary' => ['name' => 'Mavi', 'hex_code' => '#007bff',],
            'success' => ['name' => 'Yeşil', 'hex_code' => '#28a745',],
            'danger' => ['name' => 'Kırmızı', 'hex_code' => '#dc3545',],
            'warning' => ['name' => 'Sarı', 'hex_code' => '#ffc107',],
            'info' => ['name' => 'Mavi', 'hex_code' => '#17a2b8',],
        ];

        $this->extensions = [
            // images, documents, videos, audios, archives, executables
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'],
            'documents' => [
                'pdf', 'doc', 'docx', 'xls', 'xlsx',
                // 'ppt', 'pptx', 'txt', 'csv', 'rtf', 'odt', 'ods', 'odp', 'odg', 'odf', 'odb', 'odi', 'odm', 'ott', 'ots', 'otp', 'otg', 'xml', 'xps', 'dotx', 'dotm', 'xltx', 'xltm', 'xlam', 'pptx', 'pptm', 'ppsx', 'ppsm', 'potx', 'potm', 'ppam', 'sldx', 'sldm', 'thmx', 'onetoc', 'onetoc2', 'onetmp', 'onepkg', 'oxps', 'xps'
            ],
            'videos' => ['mp4', 'webm', 'mkv', 'flv', 'vob', 'ogv', 'ogg', 'avi', 'mov', 'wmv', 'qt', 'yuv', 'rm', 'rmvb', 'asf', 'amv', 'm4p', 'm4v', 'mpg', 'mp2', 'mpeg', 'mpe', 'mpv', 'm2v', 'm4v', 'svi', '3gp', '3g2', 'mxf', 'roq', 'nsv', 'flv', 'f4v', 'f4p', 'f4a', 'f4b'],
            'audios' => ['mp3', 'wav', 'flac', 'aac', 'm4a', 'wma', 'aiff', 'alac', 'amr', 'ape', 'au', 'awb', 'dct', 'dss', 'dvf', 'gsm', 'iklax', 'ivs', 'mogg', 'mpc', 'msv', 'nmf', 'nsf', 'ogg', 'opus', 'ra', 'raw', 'sln', 'tta', 'vox', 'wv', 'webm', '8svx'],
            'archives' => ['zip', 'rar', '7z', 'tar', 'gz', 'bz2', 'iso', 'dmg'],
            'executables' => ['exe', 'msi', 'bat', 'bin', 'cmd', 'com', 'cpl', 'dll', 'drv', 'efi', 'gadget', 'jar', 'msc', 'msi', 'msp', 'pif', 'ps1', 'scr', 'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'ws', 'wsh'],
        ];

        // tr karakterleri toUpper, toLower, toTitleCase için
        $this->characters = [
            'tr' => [
                'lower' => ['ç', 'ğ', 'i', 'ı', 'ö', 'ş', 'ü'],
                'upper' => ['Ç', 'Ğ', 'İ', 'I', 'Ö', 'Ş', 'Ü'],
                'title' => ['Ç', 'Ğ', 'İ', 'I', 'Ö', 'Ş', 'Ü'],
            ],
        ];

        $this->smtpSecure = [
            'tls' => 'TLS',
            'ssl' => 'SSL',
        ];

        $this->contactSubject = [
            // 'general' => 'Genel',
            'offer' => 'Teklif',
            'job' => 'İş İlanı',
            'ads' => 'Reklam',
            'other' => 'Diğer',
        ];
    }

    // user types fonksiyonu
    public function userTypes($type = 'array')
    {
        $types = $this->types;
        if ($type === 'keys') {
            return array_keys($types);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($types));
        } elseif ($type === 'auth') {
            return array_keys($types)[0];
        } elseif ($type === 'table') {
            return [
                'administrator' => '<span class="br-full badge badge-danger">' . $types['administrator'] . '</span>',
                'admin' => '<span class="br-full badge badge-success">' . $types['admin'] . '</span>',
                'user' => '<span class="br-full badge badge-info">' . $types['user'] . '</span>',
                'demo' => '<span class="br-full badge badge-warning">' . $types['demo'] . '</span>',
            ];
        } else {
            return $types;
        }
    }

    // rating fonksiyonu
    public function rating($type = 'array')
    {
        $rating = $this->rating;
        if ($type === 'keys') {
            return array_keys($rating);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($rating));
        } elseif ($type === 'table') {
            return [
                'excellent' => '<span class="br-full badge badge-success">' . $rating['excellent'] . '</span>',
                'good' => '<span class="br-full badge badge-info">' . $rating['good'] . '</span>',
                'average' => '<span class="br-full badge badge-warning">' . $rating['average'] . '</span>',
                'bad' => '<span class="br-full badge badge-danger">' . $rating['bad'] . '</span>',
                'terrible' => '<span class="br-full badge badge-dark">' . $rating['terrible'] . '</span>',
            ];
        } else {
            return $rating;
        }
    }

    // $this->rating ile starIcon fonksiyonu
    public function starIcon($rating = 'excellent', $type = 'num')
    {
        $ok_icon = '<i class="fa fa-star text-warning"></i>';
        $no_icon = '<i class="fa fa-star-o"></i>';
        if ($rating === 'excellent') {
            return $type === 'icon' ? $ok_icon . $ok_icon . $ok_icon . $ok_icon . $ok_icon : 5;
        } elseif ($rating === 'good') {
            return $type === 'icon' ? $ok_icon . $ok_icon . $ok_icon . $ok_icon . $no_icon : 4;
        } elseif ($rating === 'average') {
            return $type === 'icon' ? $ok_icon . $ok_icon . $ok_icon . $no_icon . $no_icon : 3;
        } elseif ($rating === 'bad') {
            return $type === 'icon' ? $ok_icon . $ok_icon . $no_icon . $no_icon . $no_icon : 2;
        } elseif ($rating === 'terrible') {
            return $type === 'icon' ? $ok_icon . $no_icon . $no_icon . $no_icon . $no_icon : 1;
        } else {
            return $type === 'icon' ? $no_icon . $no_icon . $no_icon . $no_icon . $no_icon : 5;
        }
    }

    // isOnline fonksiyonu
    public function isOnline($user_id, $type = 'badge')
    {
        $bool = false;
        if (Cache::has('user-is-online-' . $user_id)) {
            $bool = true;
        }
        if ($type === 'text') {
            return $bool ? '<span class="text-success">Çevrimiçi</span>' : '<span class="text-danger">Çevrimdışı</span>';
        } elseif ($type === 'icon') {
            return $bool ? '<i class="user-is-activity on"></i>' : '<i class="user-is-activity off"></i>';
        } elseif ($type === 'badge') {
            return $bool ? '<span class="br-full badge badge-success">Çevrimiçi</span>' :
                '<span class="br-full badge badge-danger">Çevrimdışı</span>';
        } elseif ($type === 'full') {
            return $bool ? '<i class="user-is-activity on"></i><span class="text-success ml-4">Çevrimiçi</span>' :
                '<i class="user-is-activity off"></i><span class="text-danger ml-4">Çevrimdışı</span>';
        }
        return $bool;
    }

    // status fonksiyonu
    public function status($type = 'array', $colmn = null)
    {
        $status = $this->status;
        if ($type === 'keys') {
            return array_keys($status);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($status));
        } elseif ($type === 'table') {
            return '<span class="badge badge-' . ($colmn === 'active' ? 'success' : 'danger') .
                '-inverse">' . ($colmn === 'active' ? $status['active'] : $status['passive']) . '</span>';
        } elseif ($type === 'hidden') {
            return $colmn === 'active' ? 'Aktif' : 'Pasif';
        } else {
            return $status;
        }
    }

    // contactSubject fonksiyonu
    public function contactSubject($type = 'array', $colmn = null)
    {
        $subject = $this->contactSubject;
        if ($type === 'keys') {
            return array_keys($subject);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($subject));
        } elseif ($type === 'table') {
            if ($colmn === 'offer') {
                return '<span class="badge badge-success-inverse">' . $subject['offer'] . '</span>';
            } elseif ($colmn === 'job') {
                return '<span class="badge badge-info-inverse">' . $subject['job'] . '</span>';
            } elseif ($colmn === 'ads') {
                return '<span class="badge badge-warning-inverse">' . $subject['ads'] . '</span>';
            } elseif ($colmn === 'other') {
                return '<span class="badge badge-danger-inverse">' . $subject['other'] . '</span>';
            }
        } elseif ($type === 'values') {
            return $subject[$colmn];
        }
        return $subject;

    }

    // target fonksiyonu
    public function target($type = 'array')
    {
        $target = $this->target;
        if ($type === 'keys') {
            return array_keys($target);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($target));
        } else {
            return $target;
        }
    }

    public function colors($type = 'array')
    {
        $colors = $this->colors;
        if ($type === 'keys') {
            return array_keys($colors);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($colors));
        } else {
            return [
                'primary' => '<span class="br-full badge badge-primary">' . $colors['primary'] . '</span>',
                'secondary' => '<span class="br-full badge badge-secondary">' . $colors['secondary'] . '</span>',
                'success' => '<span class="br-full badge badge-success">' . $colors['success'] . '</span>',
                'danger' => '<span class="br-full badge badge-danger">' . $colors['danger'] . '</span>',
                'warning' => '<span class="br-full badge badge-warning">' . $colors['warning'] . '</span>',
                'info' => '<span class="br-full badge badge-info">' . $colors['info'] . '</span>',
            ];
        }
    }

    // izin verilen resim uzantıları fonksiyonu
    public function extensions($type)
    {
        $extensions = $this->extensions;
        return implode(',', $extensions[$type]);
    }

    // SMTP güvenlik seçenekleri
    public function smtpSecure($type = 'array')
    {
        $smtpSecure = $this->smtpSecure;
        if ($type === 'keys') {
            return array_keys($smtpSecure);
        } elseif ($type === 'rules') {
            return implode(',', array_keys($smtpSecure));
        } else {
            return $smtpSecure;
        }
    }

    public static function isAdmin()
    {
        return Auth::check() && (Auth::user()->type === 'admin' || Auth::user()->type === 'administrator');
    }

    // slug fonksiyonu
    public static function slug($string)
    {
        $string = mb_strtolower($string, 'UTF-8');
        $string = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c'], $string);
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
        $string = preg_replace('/[\s-]+/', ' ', $string);
        $string = preg_replace('/[\s_]/', '-', $string);
        return $string;
    }

    // slugify fonksiyonu
    public function slugify($text)
    {
        if (!empty($text)) {
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            $text = preg_replace('~[^-\w]+~', '', $text);
            $text = trim($text, '-');
            $text = preg_replace('~-+~', '-', $text);
            $text = strtolower($text);
            return $text;
        }
        return null;
    }

    // $this->characters kullanarak toUpper, toLower, toTitleCase fonksiyonları
    public function toTitleCase($text)
    {
        foreach ($this->characters as $value) {
            $text = str_replace($value['lower'], $value['title'], $text);
        }
        return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    }

    public function toUpper($text)
    {
        foreach ($this->characters as $value) {
            $text = str_replace($value['lower'], $value['upper'], $text);
        }
        return mb_strtoupper($text, 'UTF-8');
    }

    public function toLower($text)
    {
        foreach ($this->characters as $value) {
            $text = str_replace($value['upper'], $value['lower'], $text);
        }
        return mb_strtolower($text, 'UTF-8');
    }

    // assetAdmin fonksiyonu
    public function assetAdmin($path = '/')
    {
        return asset('assets/admin/' . $path);
    }

    // assetWebs fonksiyonu
    public function assetWebs($path = '/')
    {
        return asset('assets/webs/' . $path);
    }

    // storage/uploads fonksiyonu
    public function assetUploads($path = null)
    {
        return asset('uploads/' . $path);
    }

    // isInternet ile internet bağlantısı kontrolü
    public function isInternet()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            $isConn = true;
            fclose($connected);
        } else {
            $isConn = false;
        }
        return $isConn;
    }

    public function getGravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        if ($this->isInternet()) {
            $url = 'https://www.gravatar.com/avatar/';
            $url .= md5(strtolower(trim($email)));
            $url .= "?s=$s&d=$d&r=$r";
            if ($img) {
                $url = '<img src="' . $url . '"';
                foreach ($atts as $key => $val)
                    $url .= ' ' . $key . '="' . $val . '"';
                $url .= ' />';
            }
            return $url;
        } else {
            if (Route::currentRouteName() === 'admin.users.index') {
                return $this->assetAdmin('img/demo-user.png');
            } else {
                return $this->assetWebs('img/demo-user.png');
            }
        }
    }

    // getImage fonksiyonu
    public function getImage($image, $path = null, $type = 'uploads')
    {
        if ($image) {
            if ($type === 'uploads') {
                return $this->assetUploads($path . '/' . $image);
            } elseif ($type === 'webs') {
                return $this->assetWebs($path . '/' . $image);
            } elseif ($type === 'admin') {
                return $this->assetAdmin($path . '/' . $image);
            }
        } else {
            if ($type === 'uploads') {
                return $this->assetUploads('no-image.png');
            } elseif ($type === 'webs') {
                return $this->assetWebs('img/no-image.png');
            } elseif ($type === 'admin') {
                return $this->assetAdmin('img/no-image.png');
            }
        }
    }

    // auth user profile_photo_path resmi varsa getir yoksa email gravatar getir
    public function profilePhoto($path, $prefix = null)
    {
        if ($path->profile_photo_path) {
            //return Storage::disk('public')->url($path->profile_photo_path);
            return $this->assetUploads($prefix . '/' . $path->profile_photo_path);
        } else {
            return $this->getGravatar($path->email);
        }
    }

    // required fonksiyonu
    public function required()
    {
        return '(<span class="text-danger">*</span>)';
    }

    // requiredMssg fonksiyonu
    public function requiredMssg()
    {
        return '<div class="col-xxl-12 mb-3 vw-desktop">
                <div class="alert alert-light alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle"></i>
                    <strong>NOT:</strong> Doldurulması zorunlu olan alanların yanında yıldız
                    ' . $this->required() . ' işareti bulunmaktadır.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ti ti-close"></i>
                    </button>
                </div>
            </div>';
    }

    // moveInfo fonksiyonu
    public function moveInfo()
    {
        return '<div class="col-xxl-12 mb-3 vw-desktop">
                <div class="alert alert-light alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle"></i>
                    <strong>NOT:</strong> Sıralamayı değiştirmek için
                    <i class="fe fe-move"></i> ikonunu sürükleyip bırakınız.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ti ti-close"></i>
                    </button>
                </div>
            </div>';
    }


    public function alertError($errors)
    {
        $alertError = '';
        if ($errors->any()) {
            $alertError .= '<div class="col-xxl-12 mb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle"></i>
                    <strong>HATA:</strong> Form\'da hatalar var. Lütfen tüm alanları kontrol ediniz.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ti ti-close"></i>
                    </button>
                </div>
            </div>';
        }
        return $alertError;
    }

    // tab error
    public function tabError($columns, $class = null)
    {
        $addItem = '<span class="notify tab ' . $class . '"><span class="blink"></span><span class="dot"></span></span>';
        // $columns dizisi içindeki herhangi bir değer $errors->has içinde varsa $addItem değerini döndür
        foreach ($columns as $column) {
            // Session::has('errors') içinde $column değeri varsa
            if (Session::has('errors') && Session::get('errors')->has($column)) {
                return $addItem;
            }
        }

    }

    // strLimit fonksiyonu
    public function strLimit($text, $limit = 100, $end = '...')
    {
        if (mb_strlen($text, 'UTF-8') <= $limit) return $text;
        return rtrim(mb_substr($text, 0, $limit, 'UTF-8')) . $end;
    }

    // customDatetime fonksiyonu
    public function customDate($datetime)
    {
        // datetime değerini parçala
        $datetime = explode(' ', $datetime);
        $date = '<i class="text-primary fa fa-calendar-o"></i> ' . date('d/m/Y', strtotime($datetime[0]));
        $time = '<i class="text-primary fa fa-clock-o"></i> ' . date('H:i', strtotime($datetime[1]));
        return $date . ' - ' . $time;
    }

    // date fonksiyonu
    public function date($datetime)
    {
        // datetime değerini parçala
        $datetime = explode(' ', $datetime);
        return date('d.m.Y', strtotime($datetime[0]));
    }

    // time fonksiyonu
    public function time($datetime)
    {
        // datetime değerini parçala
        $datetime = explode(' ', $datetime);
        return date('H:i', strtotime($datetime[1]));
    }

    // nestable recursiveMenu fonksiyonu
    public function recursiveMenu($data, $parent_id = 0, $order = 1)
    {
        $html = '';
        foreach ($data as $key => $value) {
            if ($value->parent_id == $parent_id) {
                $html .= '<li class="dd-item no-select-text
                ' . ($value->status === 'active' ? 'badge-success-inverse' : 'badge-danger-inverse') . '"
                data-id="' . $value->id . '" data-parent-id="' . $value->parent_id . '" data-order="' . $order . '">
                    <div class="dd-handle">
                        <span class="dd-nodrag">
                           <i class="' . $value->icon . '"></i> ' . $value->name . '
                        </span>
                        <i class="fe fe-move text-primary float-right"></i>
                    </div>';
                unset($data[$key]);
                $html .= $this->recursiveMenu($data, $value->id, $order + 1);
                $html .= '</li>';
            }
        }
        return $html ? '<ol class="dd-list">' . $html . '</ol>' : $html;
    }

    // ipAdress fonksiyonu
    public function getIpOne()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = '0.0.0.0';
        }
        return $ip;
    }

    function getIpTwo()
    {
        if (getenv('HTTP_CLIENT_IP'))
            $ip = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ip = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ip = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ip = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ip = getenv('REMOTE_ADDR');
        else
            $ip = '0.0.0.0';
        return $ip;
    }

    // function layout
    public function settings($get = 'settings')
    {
        $layout = [
            'contact' => Contact::where('status', 'passive')->orderBy('id', 'desc')->get(),
            'settings' => Setting::first()
        ];
        return $layout[$get];
    }

    public function log($message, $color, $type = 'admin')
    {
        $data = ['color' => $color, 'type' => $type, 'message' => $message];
        // return app('App\Http\Controllers\Admin\LogController')->store($data);
        return (new \App\Http\Controllers\Admin\LogController)->store($data);
    }

    // uploadImage($imagePath, $image, $width, $oldFile) fonksiyonu
    public function uploadImage($imagePath, $image, $oldImage = null)
    {
        // $oldImage varsa sil
        if ($oldImage) {
            $this->deleteImage($imagePath, $oldImage);
        }
        // $imagePath dizini yoksa oluştur
        if (!file_exists($imagePath)) {
            @mkdir($imagePath, 0777, true);
        }
        // IMAGE sınıfı ile uzantılarını .webp olarak değiştir
        $image = Image::make($image)->encode('webp', 100);
        // image ismini oluştur
        $imageName = $this->slugify('eu-' . time() . '-' . uniqid()) . '.webp';
        // image kaydet
        $image->save($imagePath . $imageName);
        // image thumbnaillerini oluştur
        $thumb = Image::make($imagePath . $imageName)->fit(300, 220);
        // image thumbnaillerini kalite ayarlarıyla kaydet
        $thumb->save($imagePath . 'thumbnail_' . $imageName);
        // image ismini döndür
        return $imageName;
    }

    // deleteImage($imagePath, $image) fonksiyonu
    public function deleteImage($imagePath, $image)
    {
        $publicPath = public_path(trim($imagePath, '/'));
        if (file_exists($publicPath . '/' . $image)) {
            @unlink($publicPath . '/' . $image);
            @unlink($publicPath . '/thumbnail_' . $image);
        }
    }

    // envFileUpdate($key, $value) fonksiyonu ile önceki value değerlerini silerek yeni değerekleme fonksiyonu
    public function envFileUpdate($key, $value)
    {
        $envFile = file_get_contents(base_path() . '/.env');        // .env dosyasını oku
        $envFileData = explode("\n", $envFile);                     // .env dosyasını parçala
        foreach ($envFileData as $envFileKey => $envFileValue) {            // .env dosyasındaki her bir satırı döndür
            if (strpos($envFileValue, $key) !== false) {                    // $key değerini ara
                $envFileData[$envFileKey] = $key . '=' . "\"$value\"";      // $key değerini bulursa yeni değeri ata
            }
        }
        $envFileData = implode("\n", $envFileData);                 // .env dosyasını birleştir
        file_put_contents(base_path() . '/.env', $envFileData);     // .env dosyasını güncelle
    }

    // cleanHtml fonksiyonu



}
