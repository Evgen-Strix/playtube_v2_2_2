<?php
if (file_exists('./assets/init.php')) {
    require_once('./assets/init.php');
} else {
    die('Please put this file in the home directory !');
}
function PT_UpdateLangs($lang, $key, $value) {
    global $sqlConnect;
    $update_query         = "UPDATE langs SET `{lang}` = '{lang_text}' WHERE `lang_key` = '{lang_key}'";
    $update_replace_array = array(
        "{lang}",
        "{lang_text}",
        "{lang_key}"
    );
    return str_replace($update_replace_array, array(
        $lang,
        mysqli_real_escape_string($sqlConnect, $value),
        $key
    ), $update_query);
}
$updated = false;
if (!empty($_GET['updated'])) {
    $updated = true;
}
if (!empty($_POST['query'])) {
    $query = mysqli_query($mysqli, base64_decode($_POST['query']));
    if ($query) {
        $data['status'] = 200;
    } else {
        $data['status'] = 400;
        $data['error']  = mysqli_error($mysqli);
    }
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}
if (!empty($_POST['update_langs'])) {
    $data  = array();
    $query = mysqli_query($sqlConnect, "SHOW COLUMNS FROM `langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }
    unset($data[0]);
    unset($data[1]);
    unset($data[2]);
    $lang_update_queries = array();
    foreach ($data as $key => $value) {
        $value = ($value);
        if ($value == 'arabic') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'تجاهل الاعلانات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'إدارة أفلامي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'السبت');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'الأحد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'الاثنين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'يوم الثلاثاء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'الأربعاء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'يوم الخميس');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'جمعة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'يناير');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'شهر فبراير');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'يمشي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'أبريل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'مايو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'يونيه');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'يوليو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'أغسطس');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'سبتمبر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'اكتوبر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'شهر نوفمبر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'ديسمبر');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Advertentie overslaan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Beheer mijn films');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'zaterdag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Zondag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Maandag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Dinsdag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Woensdag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Donderdag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Vrijdag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'Januari');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'Februari');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'Maart');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'april');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'Kunnen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'juni-');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'juli-');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'augustus');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'september');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'oktober');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'November');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'December');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Passer la pub');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Gérer mes films');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'Samedi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Dimanche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Lundi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Mardi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Mercredi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Jeudi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Vendredi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'Janvier');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'Février');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'Mars');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'Avril');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'Peut');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'Juin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'Juillet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'Août');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'Septembre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'Octobre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'Novembre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'Décembre');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Überspringen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Verwalten Sie meine Filme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'Samstag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Sonntag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Montag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Dienstag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Mittwoch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Donnerstag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Freitag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'Januar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'Februar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'Marsch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'April');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'Kann');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'Juni');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'Juli');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'August');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'September');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'Oktober');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'November');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'Dezember');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Пропустить рекламу');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Управляйте моими фильмами');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'Суббота');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Воскресенье');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Понедельник');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Вторник');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Среда');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Четверг');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Пятница');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'Январь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'Февраль');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'Маршировать');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'апреля');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'Май');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'Июнь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'Июль');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'Август');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'Сентябрь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'Октябрь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'Ноябрь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'Декабрь');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Omitir aviso publicitario');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Administra mis películas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'sábado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Domingo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Lunes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'martes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'miércoles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'jueves');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Viernes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'enero');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'Febrero');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'Marzo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'Abril');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'Mayo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'Junio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'Julio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'Agosto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'Septiembre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'Octubre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'Noviembre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'Diciembre');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Reklamı geç');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Filmlerimi yönet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'Cumartesi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Pazar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Pazartesi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Salı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Çarşamba');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Perşembe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Cuma');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'Ocak');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'Şubat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'Mart');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'Nisan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'Mayıs');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'Haziran');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'Temmuz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'Ağustos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'Eylül');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'Ekim');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'Kasım');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'Aralık');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Skip Ad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Manage My Movies');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'Saturday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Sunday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Monday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Tuesday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Wednesday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Thursday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Friday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'January');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'February');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'March');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'April');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'May');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'June');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'July');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'August');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'September');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'October');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'November');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'December');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'skip_ad', 'Skip Ad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_my_movies', 'Manage My Movies');
            $lang_update_queries[] = PT_UpdateLangs($value, 'saturday', 'Saturday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sunday', 'Sunday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monday', 'Monday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'tuesday', 'Tuesday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wednesday', 'Wednesday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'thursday', 'Thursday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'friday', 'Friday');
            $lang_update_queries[] = PT_UpdateLangs($value, 'january', 'January');
            $lang_update_queries[] = PT_UpdateLangs($value, 'february', 'February');
            $lang_update_queries[] = PT_UpdateLangs($value, 'march', 'March');
            $lang_update_queries[] = PT_UpdateLangs($value, 'april', 'April');
            $lang_update_queries[] = PT_UpdateLangs($value, 'may', 'May');
            $lang_update_queries[] = PT_UpdateLangs($value, 'june', 'June');
            $lang_update_queries[] = PT_UpdateLangs($value, 'july', 'July');
            $lang_update_queries[] = PT_UpdateLangs($value, 'august', 'August');
            $lang_update_queries[] = PT_UpdateLangs($value, 'september', 'September');
            $lang_update_queries[] = PT_UpdateLangs($value, 'october', 'October');
            $lang_update_queries[] = PT_UpdateLangs($value, 'november', 'November');
            $lang_update_queries[] = PT_UpdateLangs($value, 'december', 'December');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }
    $files = array(
        'assets/import/sitemap-php',
        'assets/import/stripe',
        'assets/import/hybridauth',
        'assets/import/stripe-php-3.20.0',
        'assets/import/social-login/Adapter',
        'assets/import/social-login/Data',
        'assets/import/social-login/Exception',
        'assets/import/social-login/HttpClient',
        'assets/import/social-login/Logger',
        'assets/import/social-login/Provider',
        'assets/import/social-login/Storage',
        'assets/import/social-login/Thirdparty',
        'assets/import/social-login/User',
        'assets/import/social-login/autoload.php',
        'assets/import/social-login/Hybridauth.php'
    );
    foreach ($files as $key => $value) {
        if (file_exists($value)) {
            if (is_dir($value)) {
                deleteDirectory($value);
            } else {
                @unlink($value);
            }
        }
    }
    $name = md5(microtime()) . '_updated.php';
    rename('update.php', $name);
}
?>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <title>Updating PlayTube</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <style>
         @import url('https://fonts.googleapis.com/css?family=Roboto:400,500');
         @media print {
            .wo_update_changelog {max-height: none !important; min-height: !important}
            .btn, .hide_print, .setting-well h4 {display:none;}
         }
         * {outline: none !important;}
         body {background: #f3f3f3;font-family: 'Roboto', sans-serif;}
         .light {font-weight: 400;}
         .bold {font-weight: 500;}
         .btn {height: 52px;line-height: 1;font-size: 16px;transition: all 0.3s;border-radius: 2em;font-weight: 500;padding: 0 28px;letter-spacing: .5px;}
         .btn svg {margin-left: 10px;margin-top: -2px;transition: all 0.3s;vertical-align: middle;}
         .btn:hover svg {-webkit-transform: translateX(3px);-moz-transform: translateX(3px);-ms-transform: translateX(3px);-o-transform: translateX(3px);transform: translateX(3px);}
         .btn-main {color: #ffffff;background-color: #00BCD4;border-color: #00BCD4;}
         .btn-main:disabled, .btn-main:focus {color: #fff;}
         .btn-main:hover {color: #ffffff;background-color: #0dcde2;border-color: #0dcde2;box-shadow: -2px 2px 14px rgba(168, 72, 73, 0.35);}
         svg {vertical-align: middle;}
         .main {color: #00BCD4;}
         .wo_update_changelog {
          border: 1px solid #eee;
          padding: 10px !important;
         }
         .content-container {display: -webkit-box; width: 100%;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;flex-direction: column;min-height: 100vh;position: relative;}
         .content-container:before, .content-container:after {-webkit-box-flex: 1;box-flex: 1;-webkit-flex-grow: 1;flex-grow: 1;content: '';display: block;height: 50px;}
         .wo_install_wiz {position: relative;background-color: white;box-shadow: 0 1px 15px 2px rgba(0, 0, 0, 0.1);border-radius: 10px;padding: 20px 30px;border-top: 1px solid rgba(0, 0, 0, 0.04);}
         .wo_install_wiz h2 {margin-top: 10px;margin-bottom: 30px;display: flex;align-items: center;}
         .wo_install_wiz h2 span {margin-left: auto;font-size: 15px;}
         .wo_update_changelog {padding:0;list-style-type: none;margin-bottom: 15px;max-height: 440px;overflow-y: auto; min-height: 440px;}
         .wo_update_changelog li {margin-bottom:7px; max-height: 20px; overflow: hidden;}
         .wo_update_changelog li span {padding: 2px 7px;font-size: 12px;margin-right: 4px;border-radius: 2px;}
         .wo_update_changelog li span.added {background-color: #4CAF50;color: white;}
         .wo_update_changelog li span.changed {background-color: #e62117;color: white;}
         .wo_update_changelog li span.improved {background-color: #9C27B0;color: white;}
         .wo_update_changelog li span.compressed {background-color: #795548;color: white;}
         .wo_update_changelog li span.fixed {background-color: #2196F3;color: white;}
         input.form-control {background-color: #f4f4f4;border: 0;border-radius: 2em;height: 40px;padding: 3px 14px;color: #383838;transition: all 0.2s;}
input.form-control:hover {background-color: #e9e9e9;}
input.form-control:focus {background: #fff;box-shadow: 0 0 0 1.5px #a84849;}
         .empty_state {margin-top: 80px;margin-bottom: 80px;font-weight: 500;color: #6d6d6d;display: block;text-align: center;}
         .checkmark__circle {stroke-dasharray: 166;stroke-dashoffset: 166;stroke-width: 2;stroke-miterlimit: 10;stroke: #7ac142;fill: none;animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;}
         .checkmark {width: 80px;height: 80px; border-radius: 50%;display: block;stroke-width: 3;stroke: #fff;stroke-miterlimit: 10;margin: 100px auto 50px;box-shadow: inset 0px 0px 0px #7ac142;animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;}
         .checkmark__check {transform-origin: 50% 50%;stroke-dasharray: 48;stroke-dashoffset: 48;animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;}
         @keyframes stroke { 100% {stroke-dashoffset: 0;}}
         @keyframes scale {0%, 100% {transform: none;}  50% {transform: scale3d(1.1, 1.1, 1); }}
         @keyframes fill { 100% {box-shadow: inset 0px 0px 0px 54px #7ac142; }}
      </style>
   </head>
   <body>
      <div class="content-container container">
         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
               <div class="wo_install_wiz">
                 <?php if ($updated == false) { ?>
                  <div>
                     <h2 class="light">Update to v2.2.2 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                          <li>[Added] user roles, admin, moderator, and editor.</li>
                          <li>[Added] debug system for FFMPEG to admin panel. </li>
                          <li>[Added] the ability to translate dates.</li>
                          <li>[Added] the ability to choose player color on embed. </li>
                          <li>[Added] category list on home page. in default theme. </li>
                          <li>[Added] developer mode in admin panel. </li>
                          <li>[Updated] all PHP libs to latest version & removed unused libs. </li>
                          <li>[Improved] design of shorts on home page and profile. </li>
                          <li>[Improved] design of monetization page.</li>
                          <li>[Improved] design of pro system page on youplay. </li>
                          <li>[Improved] design of manage sessions and balance pages. </li>
                          <li>[Improved] design of radio boxes on default theme. </li>
                          <li>[Improved] design of playlist models.</li>
                          <li>[Improved] design of history page on youplay.</li>
                          <li>[Improved] hover effects on some elements. </li>
                          <li>[Improved] movies page on youplay. </li>
                          <li>[Improved] stock videos page on youplay. </li>
                          <li>[Improved] speed on top videos page, it was a bit slow.</li>
                          <li>[Fixed] shorts were showing order by last, now by views.</li>
                          <li>[Fixed] ajax load was not working on phones.</li>
                          <li>[Fixed] users couldn't reply to comments on posts. </li>
                          <li>[Fixed] clicking share button on youplay home page wasn't opening the share dialog.</li>
                          <li>[Fixed] private videos were added to sitemap.</li>
                          <li>[Fixed] google login.</li>
                          <li>[Fixed] users weren't able to pay more than $1,000 in wallet.</li>
                          <li>[Fixed] wasabi bucket only allowed us-east-1.</li>
                          <li>[Fixed] movies search system was broken.</li>
                          <li>[Fixed] blank video on liked videos page showing to some users.</li>
                          <li>[Fixed] +10 minor bugs.</li>
                        </ul>
                        <p class="hide_print">Note: The update process might take few minutes.</p>
                        <p class="hide_print">Important: If you got any fail queries, please copy them, open a support ticket and send us the details.</p>
                        <br>
                             <button class="pull-right btn btn-default" onclick="window.print();">Share Log</button>
                             <button type="button" class="btn btn-main" id="button-update">
                             Update
                             <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path>
                             </svg>
                          </button>
                     </div>
                     <?php }?>
                     <?php if ($updated == true) { ?>
                      <div>
                        <div class="empty_state">
                           <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                           </svg>
                           <p>Congratulations, you have successfully updated your site. Thanks for choosing PlayTube.</p>
                           <br>
                           <a href="<?php echo $wo['config']['site_url'] ?>" class="btn btn-main" style="line-height:50px;">Home</a>
                        </div>
                     </div>
                     <?php }?>
                  </div>
               </div>
            </div>
            <div class="col-md-1"></div>
         </div>
      </div>
   </body>
</html>
<script>
var queries = [
    "UPDATE `config` SET `value` = '2.2.2' WHERE `name` = 'version';",
    "ALTER TABLE `users` ADD `permission` VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `tv_code`, ADD INDEX (`permission`);",
    "ALTER TABLE `videos` ADD INDEX(`is_stock`);",
    "ALTER TABLE `videos` ADD INDEX(`time_date`);",
    "ALTER TABLE `videos` ADD INDEX(`publication_date`);",
    "ALTER TABLE `videos` ADD INDEX(`live_time`);",
    "ALTER TABLE `views` ADD INDEX( `video_id`, `time`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'developer_mode', 'off');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'skip_ad');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'manage_my_movies');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'saturday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'sunday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'monday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'tuesday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'wednesday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'thursday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'friday');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'january');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'february');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'march');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'april');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'may');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'june');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'july');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'august');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'september');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'october');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'november');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'december');",
];

$('#input_code').bind("paste keyup input propertychange", function(e) {
    if (isPurchaseCode($(this).val())) {
        $('#button-update').removeAttr('disabled');
    } else {
        $('#button-update').attr('disabled', 'true');
    }
});

function isPurchaseCode(str) {
    var patt = new RegExp("(.*)-(.*)-(.*)-(.*)-(.*)");
    var res = patt.test(str);
    if (res) {
        return true;
    }
    return false;
}

$(document).on('click', '#button-update', function(event) {
    if ($('body').attr('data-update') == 'true') {
        window.location.href = '<?php echo $site_url?>';
        return false;
    }
    $(this).attr('disabled', true);
    $('.wo_update_changelog').html('');
    $('.wo_update_changelog').css({
        background: '#1e2321',
        color: '#fff'
    });
    $('.setting-well h4').text('Updating..');
    $(this).attr('disabled', true);
    RunQuery();
});

var queriesLength = queries.length;
var query = queries[0];
var count = 0;
function b64EncodeUnicode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}
function RunQuery() {
    var query = queries[count];
    $.post('?update', {
        query: b64EncodeUnicode(query)
    }, function(data, textStatus, xhr) {
        if (data.status == 200) {
            $('.wo_update_changelog').append('<li><span class="added">SUCCESS</span> ~$ mysql > ' + query + '</li>');
        } else {
            $('.wo_update_changelog').append('<li><span class="changed">FAILED</span> ~$ mysql > ' + query + '</li>');
        }
        count = count + 1;
        if (queriesLength > count) {
            setTimeout(function() {
                RunQuery();
            }, 1500);
        } else {
            $('.wo_update_changelog').append('<li><span class="added">Updating Langauges & Categories</span> ~$ languages.sh, Please wait, this might take some time..</li>');
            $.post('?run_lang', {
                update_langs: 'true'
            }, function(data, textStatus, xhr) {
              $('.wo_update_changelog').append('<li><span class="fixed">Finished!</span> ~$ Congratulations! you have successfully updated your site. Thanks for choosing PlayTube.</li>');
              $('.setting-well h4').text('Update Log');
              $('#button-update').html('Home <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"> <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path> </svg>');
              $('#button-update').attr('disabled', false);
              $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
              $('body').attr('data-update', 'true');
            });
        }
        $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
    });
}
</script>
