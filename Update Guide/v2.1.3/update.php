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
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'سياسة الاسترجاع');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'أسئلة وأجوبة');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'سنعود قريبا!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'آسف للإزعاج لكننا نؤدي بعض الصيانة في الوقت الحالي. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'خلاف ذلك، سنعود عبر الإنترنت قريبا!');
        } else if ($value == 'dutch') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Restitutiebeleid');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'Veelgestelde vragen');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'We zullen snel terug zijn!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Sorry voor het ongemak, maar we uitvoeren op dit moment wat onderhoud. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'Anders zullen we binnenkort online zijn!');
        } else if ($value == 'french') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Politique de remboursement');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'Faqs');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'Nous reviendrons bientôt!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Désolé pour le désagrément occasionné, mais nous effectuons un peu de maintenance pour le moment. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'Sinon, nous serons de retour en ligne sous peu!');
        } else if ($value == 'german') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Rückgaberecht');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'FAQs');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'Wir werden bald zurück sein!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Entschuldigung für die Unannehmlichkeiten, aber wir haben im Moment etwas Wartung. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'Ansonsten werden wir kurz online sein!');
        } else if ($value == 'russian') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Политика возврата');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'Часто задаваемые вопросы');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'Мы скоро вернемся!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Извините за неудобства, но мы выполняем некоторое обслуживание в данный момент. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'В противном случае мы вернемся в ближайшее время!');
        } else if ($value == 'spanish') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Politica de reembolso');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'Preguntas frecuentes');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', '¡Estaremos de vuelta pronto!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Lo siento por los inconvenientes, pero realizamos algún mantenimiento en este momento. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'De lo contrario, volveremos en línea en breve!');
        } else if ($value == 'turkish') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Geri ödeme politikası');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'SSS');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'Yakında döneceğiz!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Rahatsızlık için özür dilerim ama şu anda biraz bakım yapıyoruz. ');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'Aksi takdirde, kısa sürede çevrimiçi olacağız!');
        } else if ($value == 'english') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Refund Policy');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'FAQs');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'We’ll be back soon!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Sorry for the inconvenience but we performing some maintenance at the moment. If you need help you can always');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'otherwise, we will be back online shortly!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'published_in', 'Published in');
        } else if ($value != 'english') {
          $lang_update_queries[] = PT_UpdateLangs($value, 'refund_policy', 'Refund Policy');
          $lang_update_queries[] = PT_UpdateLangs($value, 'faqs', 'FAQs');
          $lang_update_queries[] = PT_UpdateLangs($value, 'get_back_soon', 'We’ll be back soon!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'maintenance_text', 'Sorry for the inconvenience but we performing some maintenance at the moment. If you need help you can always');
          $lang_update_queries[] = PT_UpdateLangs($value, 'well_be_back_shortly', 'otherwise, we will be back online shortly!');
          $lang_update_queries[] = PT_UpdateLangs($value, 'published_in', 'Published in');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
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
                     <h2 class="light">Update to v2.1.3 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                          <li>[Added] maintenance mode To Admin -> Settings -> General Configuration.</li>
                          <li>[Added] LinkedIn, Vkontakte, Instagram, QQ, WeChat, Discord & Mailru social login. </li>
                          <li>[Added] refund policy page to Admin Panel -> Pages -> Manage Pages.</li>
                          <li>[Added] HTML editor to Admin Panel -> Pages -> Manage Pages.</li>
                          <li>[Added] faqs page to Admin Panel -> Pages -> Manage FAQs.</li>
                          <li>[Fixed] subscription count on youplay theme.</li>
                          <li>[Fixed] upload max size in admin panel.</li>
                          <li>[Fixed] english mistakes in Admin Panel.</li>
                          <li>[Updated] blog design on both themes.</li>
                          <li>[Updated] documentation, <a href="https://docs.playtubescript.com/" target="_blank">https://docs.playtubescript.com/</a> </li>
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
    "UPDATE `config` SET `value` = '2.1.3' WHERE `name` = 'version';",
  "CREATE TABLE `faqs` (  `id` int(11) NOT NULL,  `question` varchar(100) NOT NULL DEFAULT '',  `answer` text DEFAULT NULL,  `time` int(11) NOT NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
  "ALTER TABLE `faqs`  ADD PRIMARY KEY (`id`);",
  "ALTER TABLE `faqs`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'maintenance_mode', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'linkedinAppId', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'linkedinAppKey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'VkontakteAppId', '');;",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'VkontakteAppKey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'instagramAppkey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'instagramAppId', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'qqAppId', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'qqAppkey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'WeChatAppId', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'WeChatAppkey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'DiscordAppId', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'DiscordAppkey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'MailruAppId', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'MailruAppkey', '');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'mailru_login', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'discord_login', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'wechat_login', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'qq_login', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'instagram_login', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'vkontakte_login', 'off');",
  "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'linkedin_login', 'off');",
  "INSERT INTO `terms` (`id`, `type`, `text`) VALUES (NULL, 'refund', '');",
  "ALTER TABLE `users` ADD `vk` VARCHAR(18) NOT NULL DEFAULT '' AFTER `newsletters`, ADD `qq` VARCHAR(18) NOT NULL DEFAULT '' AFTER `vk`, ADD `wechat` VARCHAR(18) NOT NULL DEFAULT '' AFTER `qq`, ADD `discord` VARCHAR(18) NOT NULL DEFAULT '' AFTER `wechat`, ADD `mailru` VARCHAR(18) NOT NULL DEFAULT '' AFTER `discord`;",
  "ALTER TABLE `users` ADD `linkedIn` VARCHAR(18) NOT NULL DEFAULT '' AFTER `mailru`;",
  "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'refund_policy');",
  "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'faqs');",
  "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'get_back_soon');",
  "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'maintenance_text');",
  "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'well_be_back_shortly');",
  "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'published_in');"

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
