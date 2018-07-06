# template

ini adalah template codeigniter 

### Table of Contents
1. [General_controller](https://github.com/christianlimanto95/template/blob/master/README.md#1-dalam-folder-core-terdapat-general_controller)
2. File yang harus ada dalam setiap page
3. Letak File2 Umum
4. Format Penulisan


### 1. Dalam folder `core`, terdapat `General_controller`
Setiap controller selalu `extends General_controller`.

Dalam General_controller terdapat function2 umum yg dapat dipakai di controller yg membutuhkan, yaitu : 
- `view()`
- `is_loggged_in()`
- `load_additional_css()`
- `load_additional_js()`
- dll.

Contoh :
```
Class Home_controller extends General_controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$data = array(
			"title" => "My Home"
		);
		
		parent::view("home", $data);
	}
}
```
Untuk memanggil view, selalu dengan `pareng::view("nama_page", $data);`.

Variabel `$data` harus ada minimal `title`, karena ini akan diproses di file `header.php` menjadi nama tab halaman pada browser.

### 2. Untuk setiap page, file yg harus ada :
- Controller
- Model
- View
- CSS
- JS

##### Contoh page `Home` :
- Controller : Home_controller.php (huruf besar di depan)
- Model : Home_model.php (huruf besar di depan)
- View : home.php
- CSS : home.css
- JS : home.js


### 3. Letak File2 Umum :
- `header` terletak di folder `view/template/header.php`
- `footer` terletak di folder `view/template/footer.php`
- CSS terletak di folder `assets/css/nama_file.css`
- JS terletak di folder `assets/js/nama_file.js`


### 4. Format Penulisan
- Setiap nama function dan variabel pada controller dan model, jika lebih dari 1 kata, selalu dihubungkan dengan underscore `_`. Contoh :
- `function load_additional_css()`
- nama variabel `$user_email`
