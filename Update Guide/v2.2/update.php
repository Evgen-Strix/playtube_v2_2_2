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
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<h4> 1- اكتب شروط الاستخدام هنا. </h4> <br> lorem ipsum dolor sit amet ، exectetur adipising elit ، sed do eiusmod reghidunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<h4> 1- اكتب عن موقع الويب الخاص بك هنا. </h4> lorem ipsum dolor sit amet ، exectetur adipising elit ، sed do eiusmod recididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<h4> 1- صفحة الاسترداد. </h4> lorem ipsum dolor sit amet ، exectetur adipising elit ، sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'السراويل القصيرة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'الحد الأقصى لمدة الفيديو المسموح به هو {d} ثانية.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'الكمية فارغة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Outlize.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'فورتومو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Ngenius');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'المدفوعات Coinpays');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'تم إلغاء الدفع الخاص بك باستخدام المدفوعات coinpays');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'تمت الموافقة على الدفع الخاص بك باستخدام المدفوعات coinpays');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'ليس لديك رصيد كافٍ للشراء ، يرجى زيادة محفظتك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'الدفع بالمحفظة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'أنت على وشك الترقية إلى عضو محترف.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'الدفع بنجاح ، شكرا لك!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'أنت على وشك الاشتراك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'أنت على وشك شراء الفيديو.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'أنت على وشك استئجار الفيديو.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'الكثير من محاولات تسجيل الدخول يرجى المحاولة مرة أخرى لاحقًا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'تذكر هذا الجهاز');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'يجب ألا يقل طول الأحرف عن 6 أحرف.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'يجب أن تحتوي على حرف صغير.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'يجب أن تحتوي على حرف كبير.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'يجب أن تحتوي على رقم أو شخصية خاصة.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'لا تلبي كلمة المرور المقدمة الحد الأدنى من متطلبات التعقيد.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'اسمك الأول واسم العائلة لا يمكن أن يكون فارغًا.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'روابط الدعوة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'غير محدود');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'الروابط المتاحة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'روابط تم إنشاؤها');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'الروابط المستخدمة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'توليد روابط');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'تم إنشاء الكود بنجاح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'ينسخ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'نسخ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'عنوان URL');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'المستخدم المستخدم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'تاريخ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'يرجى ملاحظة أن الحد الأقصى المدة السماح هو {x} ثانية.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'قطع الفيديو');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Schrijf hier uw gebruiksvoorwaarden. </h4> <br> Lorem ipsum dolor Sit Amet, Consectetur Adipisicing elit, sed do eiusmod Temporididunt Ut Labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<H4> 1- Schrijf hier over uw website. </h4> Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elit, SED Do Eiusmod TemporidIDUNT UT Labore et Dolore Magna Aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<H4> 1- Restitiepagina. </h4> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Korte broek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'De maximale toegestane videoduur is {d} seconden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Het bedrag is leeg');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Autorize.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'NGENIUS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Munten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Uw betaling met behulp van CoinPayments is geannuleerd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Uw betaling met behulp van CoinPayments is goedgekeurd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'U hebt niet genoeg balans om te kopen, vul uw portemonnee aan.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Betaal per portemonnee');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'U staat op het punt te upgraden naar een PRO -lid.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Betaling succesvol gedaan, bedankt!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'U staat op het punt zich te abonneren.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'Je staat op het punt om video te kopen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'Je staat op het punt om video te huren.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Te veel inlogpogingen, probeer het later opnieuw');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'Onthoud dit apparaat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Moet minimaal 6 tekens lang zijn.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Moet een kleine letter bevatten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Moet een hoofdletter bevatten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Moet een nummer of speciaal teken bevatten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'Het geleverde wachtwoord voldoet niet aan de minimale complexiteitsvereisten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Uw voornaam en achternaam kunnen niet leeg zijn.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Uitnodigingslinks');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Onbeperkt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Beschikbare links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Gegenereerde links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Gebruikte links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Genereer links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Code met succes gegenereerd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Kopiëren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Gekopieerd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'Url');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Uitgenodigde gebruiker');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Datum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Houd er rekening mee dat maximale duur {x} seconden is.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Snijd de video');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<h4> 1- Écrivez vos conditions d\'utilisation ici. </h4> <br> Lorem ipsum Dolor Sit Amet, Consectetur Adipising Elit, sed do eiusmod tempory incidint ut Labore et Dolore Magna Aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<h4> 1- Écrivez sur votre site Web ici. </h4> Lorem ipsum Dolor Sit Amet, Adipising Elit de consentetur, sed do eiusmod tempory incidint ut Labore et Dolore Magna Aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<h4> 1- Page de remboursement. </h4> Lorem ipsum Dolor Sit Amet, Adipising Elipicing Elit, sed do eiusmod tempory incidint ut Labore et Dolore Magna Aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Shorts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'La durée vidéo maximale autorisée est {d} secondes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Le montant est vide');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Coiffeur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Authoriser.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Joom');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coincement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'NGENIUS');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Paiement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Votre paiement à l\'aide de CoinPayments a été annulé');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Votre paiement à l\'aide de CoinPayments a été approuvé');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Vous n\'avez pas assez de solde pour acheter, veuillez compléter votre portefeuille.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Payer par portefeuille');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'Vous êtes sur le point de passer à un membre PRO.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Paiement avec succès, merci!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'Vous êtes sur le point de vous abonner.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'Vous êtes sur le point d\'acheter une vidéo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'Vous êtes sur le point de louer une vidéo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Trop de tentatives de connexion s\'il vous plaît réessayer plus tard');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'N\'oubliez pas cet appareil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Doit contenir au moins 6 caractères.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Doit contenir une lettre minuscule.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Doit contenir une lettre majuscule.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Doit contenir un numéro ou un caractère spécial.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'Le mot de passe fourni ne répond pas aux exigences de complexité minimale.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Votre prénom et votre nom de famille ne peuvent pas être vides.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Liens d\'invitation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Illimité');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Liens disponibles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Liens générés');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Liens d\'occasion');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Générer des liens');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Code généré avec succès');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Copié');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'URL');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Utilisateur invité');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Veuillez noter que la durée maximale est {x} secondes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Couper la vidéo');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Schreiben Sie hier Ihre Nutzungsbedingungen. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<H4> 1- Schreiben Sie hier über Ihre Website. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<h4> 1- Rückerstattung Seite. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Kurze Hose');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'Die maximale Videodauer ist {d} Sekunden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Menge ist leer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'SecurionPay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Autorize.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Ngenius');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Münzen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Ihre Zahlung mit Coinpayments wurde storniert');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Ihre Zahlung mit Coinpayments wurde genehmigt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Sie haben nicht genug Balance zum Kauf. Bitte geben Sie Ihre Brieftasche auf.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Zahlen Sie nach Brieftasche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'Sie stehen kurz vor dem Upgrade auf ein Pro -Mitglied.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Zahlung erfolgreich erledigt, danke!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'Sie sind kurz davor zu abonnieren.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'Sie sind kurz davor, Videos zu kaufen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'Sie sind kurz davor, Videos zu mieten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Zu viele Anmeldeversuche versuchen bitte es später erneut');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'erinnern Sie sich an dieses Gerät');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Muss mindestens 6 Zeichen lang sein.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Muss einen Kleinbuchstaben enthalten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Muss einen Großbuchstaben enthalten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Muss eine Nummer oder ein spezielles Zeichen enthalten.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'Das gelieferte Passwort entspricht nicht den Anforderungen an die Mindestkomplexität.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Ihr Vorname und Ihr Nachname können nicht leer sein.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Einlagenlinks');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Unbegrenzt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Verfügbare Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Erzeugte Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Gebrauchte Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Links generieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Code erfolgreich generiert');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Kopieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Kopiert');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'URL');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Eingeladener Benutzer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Datum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Bitte beachten Sie, dass die maximale Dauer {x} Sekunden beträgt.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Schneiden Sie das Video');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<h4> 1- Напишите свои условия использования здесь. </h4> <br> lorem ipsum dolor sit amet, Entectutur alit, sed do eiusmod temper incididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<h4> 1- Напишите о своем веб-сайте здесь. </h4> Lorem ipsum dolor sit amet, edipisuction elit, sed do eiusmod temper incididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<h4> 1- Страница возврата. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Шорты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'Максимальная допустимая продолжительность видео составляет {D} секунд.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Сумма пуста');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Securionpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Authorize.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Формумо');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Нгений');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Аамарпай');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Coinpayments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Ваш платеж с использованием CoinPayments был отменен');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Ваш платеж с использованием CoinPayments был утвержден');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'У вас недостаточно баланса, чтобы купить, пожалуйста, пополните свой кошелек.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Оплата по кошельку');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'Вы собираетесь перейти к Pro -члену.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Оплата успешно сделана, спасибо!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'Вы собираетесь подписаться.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'Вы собираетесь приобрести видео.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'Вы собираетесь арендовать видео.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Слишком много попыток входа в систему, попробуйте еще раз позже');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'Помните это устройство');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Должно быть не менее 6 символов длиной.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Должен содержать строчную букву.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Должен содержать заглавную букву.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Должен содержать номер или особый характер.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'Поставляемый пароль не соответствует требованиям к минимальной сложности.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Ваше имя и фамилия не могут быть пустыми.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Пригласительные ссылки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Неограниченный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Доступные ссылки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Сгенерированные ссылки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Использовали ссылки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Генерировать ссылки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Код успешно сгенерирован');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Копия');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Скопированный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'URL');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Приглашенный пользователь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Свидание');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Обратите внимание, что максимальная продолжительность разрешения составляет {x} секунд.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Вырежьте видео');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<h4> 1- Escriba sus términos de uso aquí. </h4> <br> lorem ipsum dolor sit amet, consecttet adipising elit, sed do eiusmod tempor incididunt ut labore et dolor magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<H4> 1- Escriba sobre su sitio web aquí. </h4> lorem ipsum dolor sit amet, consectetur adipising elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<h4> 1- Página de reembolso. </h4> lorem ipsum dolor sit amet, consectetur adipising elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Pantalones cortos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'La duración máxima de video permitida es {d} segundos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'La cantidad está vacía');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Apagón');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Autorizar.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Nenio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Municipios');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Su pago utilizando CoinPayments ha sido cancelado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Su pago utilizando CoinPayments ha sido aprobado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'No tiene suficiente equilibrio para comprar, por favor, recargue su billetera.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Pagar por billetera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'Estás a punto de actualizar a un miembro profesional.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Pago realizado con éxito, ¡gracias!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'Estás a punto de suscribirte.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'Estás a punto de comprar un video.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'Estás a punto de alquilar video.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Demasiados intentos de inicio de sesión, inténtelo de nuevo más tarde');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'Recuerde este dispositivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Debe tener al menos 6 caracteres de largo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Debe contener una letra minúscula.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Debe contener una letra mayúscula.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Debe contener un número o carácter especial.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'La contraseña suministrada no cumple con los requisitos mínimos de complejidad.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Su primer nombre y apellido no pueden estar vacíos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Enlaces de invitación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Ilimitado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Enlaces disponibles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Enlaces generados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Enlaces usados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Generar enlaces');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Código generado con éxito');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copiar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Copiado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'Url');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Usuario invitado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Fecha');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Tenga en cuenta que el permiso de duración máxima es {x} segundos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Cortar el video');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Kullanım Koşullarınızı buraya yazın. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '<h4> 1- Web siteniz hakkında buraya yazın. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '<H4> 1- RADED PAGE. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Şort');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'İzin verilen maksimum video süresi {d} saniyedir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Miktar boş');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'Sepurionpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Jomersize.net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Paraya bakan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Ngenius');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Madeni para');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Coinpayments kullanarak ödemeniz iptal edildi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Coinpayments kullanarak ödemeniz onaylandı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'Satın almak için yeterli bakiyeniz yok, lütfen cüzdanınızı doldurun.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Cüzdanla Öde');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'Bir profesyonel üyeye yükseltmek üzeresiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Ödeme başarıyla yapıldı, teşekkür ederim!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'Abone olmak üzeresiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'Video satın almak üzeresiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'Video kiralamak üzeresiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Çok fazla giriş denemesi lütfen daha sonra tekrar deneyin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'Bu cihazı hatırla');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'En az 6 karakter uzunluğunda olmalıdır.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Küçük bir harf içermelidir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Bir büyük harf içermeli.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Bir sayı veya özel karakter içermelidir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'Sağlanan şifre, minimum karmaşıklık gereksinimlerini karşılamaz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Adınız ve soyadınız boş olamaz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Davet Bağlantıları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Sınırsız');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Mevcut bağlantılar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Oluşturulan bağlantılar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Kullanılmış bağlantılar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Bağlantılar Oluşturun');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Kod başarıyla oluşturuldu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Kopya');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Kopyalanmış');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'Url');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Davet edilen kullanıcı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Tarih');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Maksimum süre izin vermenin {x} saniye olduğunu lütfen unutmayın.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Videoyu kes');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '&lt;h4&gt;1- Write your Terms Of Use here.&lt;/h4&gt; &lt;br&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &lt;br&gt;&lt;br&gt; &lt;h4&gt;2- Random title&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '&lt;h2&gt;Who we are?&lt;/h2&gt;Provide name and contact details of the data controller. This will typically be your business or you, if you are a sole trader. Where applicable, you should include the identity and contact details of the controller’s representative and/or the data protection officer. &lt;br&gt;&lt;h2&gt;What information do we collect?&lt;/h2&gt; Specify the types of personal information you collect, eg names, addresses, user names, etc. You should include specific details on: &lt;br&gt;how you collect data (eg when a user registers, purchases or uses your services, completes a contact form, signs up to a newsletter, etc) &lt;br&gt;what specific data you collect through each of the data collection method &lt;br&gt;if you collect data from third parties, you must specify categories of data and source &lt;br&gt;if you process sensitive personal data or financial information, and how you handle this &lt;br&gt;&lt;br&gt;You may want to provide the user with relevant definitions in relation to personal data and sensitive personal data. &lt;br&gt;&lt;br&gt;&lt;h2&gt;How do we use personal information?&lt;/h2&gt;Describe in detail all the service- and business-related purposes for which you will process data. For example, this may include things like: &lt;br&gt;personalisation of content, business information or user experience &lt;br&gt;account set up and administration &lt;br&gt;delivering marketing and events communication &lt;br&gt;carrying out polls and surveys &lt;br&gt;internal research and development purposes &lt;br&gt;providing goods and services &lt;br&gt;legal obligations (eg prevention of fraud) &lt;br&gt;meeting internal audit requirements &lt;br&gt;&lt;br&gt;Please note this list is not exhaustive. You will need to record all purposes for which you process personal data. &lt;br&gt; &lt;br&gt;&lt;h2&gt;What legal basis do we have for processing your personal data?&lt;/h2&gt;Describe the relevant processing conditions contained within the GDPR. There are six possible legal grounds: &lt;br&gt;consent &lt;br&gt;contract &lt;br&gt;legitimate interests &lt;br&gt;vital interests &lt;br&gt;public task &lt;br&gt;legal obligation &lt;br&gt;&lt;br&gt;Provide detailed information on all grounds that apply to your processing, and why. If you rely on consent, explain how individuals can withdraw and manage their consent. If you rely on legitimate interests, explain clearly what these are. &lt;br&gt; &lt;br&gt;If you’re processing special category personal data, you will have to satisfy at least one of the six processing conditions, as well as additional requirements for processing under the GDPR. Provide information on all additional grounds that apply. &lt;br&gt; &lt;br&gt;&lt;h2&gt;When do we share personal data?&lt;/h2&gt;Explain that you will treat personal data confidentially and describe the circumstances when you might disclose or share it. Eg, when necessary to provide your services or conduct your business operations, as outlined in your purposes for processing. You should provide information on: &lt;br&gt;how you will share the data &lt;br&gt;what safeguards you will have in place &lt;br&gt;what parties you may share the data with and why &lt;br&gt; &lt;br&gt;&lt;h2&gt;Where do we store and process personal data?&lt;/h2&gt; If applicable, explain if you intend to store and process data outside of the data subject’s home country. Outline the steps you will take to ensure the data is processed according to your privacy policy and the applicable law of the country where data is located. &lt;br&gt; &lt;br&gt;If you transfer data outside the European Economic Area, outline the measures you will put in place to provide an appropriate level of data privacy protection. Eg contractual clauses, data transfer agreements, etc. &lt;br&gt; &lt;br&gt;&lt;h2&gt;How do we secure personal data?&lt;/h2&gt; Describe your approach to data security and the technologies and procedures you use to protect personal information. For example, these may be measures: &lt;br&gt;to protect data against accidental loss &lt;br&gt;to prevent unauthorised access, use, destruction or disclosure &lt;br&gt;to ensure business continuity and disaster recovery &lt;br&gt;to restrict access to personal information &lt;br&gt;to conduct privacy impact assessments in accordance with the law and your business policies &lt;br&gt;to train staff and contractors on data security &lt;br&gt;to manage third party risks, through use of contracts and security reviews &lt;br&gt; &lt;br&gt;Please note this list is not exhaustive. You should record all mechanisms you rely on to protect personal data. You should also state if your organisation adheres to certain accepted standards or regulatory requirements. &lt;br&gt; &lt;br&gt;&lt;h2&gt;How long do we keep your personal data for?&lt;/h2&gt; &lt;br&gt;Provide specific information on the length of time you will keep the information for in relation to each processing purpose. The GDPR requires you to retain data for no longer than reasonably necessary. Include details of your data or records retention schedules, or link to additional resources where these are published. &lt;br&gt; &lt;br&gt;If you cannot state a specific period, you need to set out the criteria you will apply to determine how long to keep the data for (eg local laws, contractual obligations, etc) &lt;br&gt; &lt;br&gt;You should also outline how you securely dispose of data after you no longer need it. &lt;br&gt;&lt;br&gt;&lt;h2&gt;Your rights in relation to personal data&lt;/h2&gt; Under the GDPR, you must respect the right of data subjects to access and control their personal data. In your privacy notice, you must outline their rights in respect of: &lt;br&gt;access to personal information &lt;br&gt;correction and deletion &lt;br&gt;withdrawal of consent (if processing data on condition of consent) &lt;br&gt;data portability &lt;br&gt;restriction of processing and objection &lt;br&gt;lodging a complaint with the Information Commissioner’s Office &lt;br&gt; &lt;br&gt;You should explain how individuals can exercise their rights, and how you plan to respond to subject data requests. State if any relevant exemptions may apply and set out any identity verification procedures you may rely on. &lt;br&gt; &lt;br&gt;Include details of the circumstances where data subject rights may be limited, eg if fulfilling the data subject request may expose personal data about another person, or if you’re asked to delete data which you are required to keep by law. &lt;br&gt; &lt;br&gt;&lt;h2&gt;Use of automated decision-making and profiling&lt;/h2&gt; Where you use profiling or other automated decision-making, you must disclose this in your privacy policy. In such cases, you must provide details on existence of any automated decision-making, together with information about the logic involved, and the likely significance and consequences of the processing of the individual. &lt;br&gt; &lt;br&gt;&lt;h2&gt;How to contact us?&lt;/h2&gt; Explain how data subject can get in touch if they have questions or concerns about your privacy practices, their personal information, or if they wish to file a complaint. Describe all ways in which they can contact you – eg online, by email or postal mail. &lt;br&gt;&gt; &lt;br&gt;If applicable, you may also include information on: &lt;br&gt; &lt;br&gt;&lt;h2&gt;Use of cookies and other technologies&lt;/h2&gt; You may include a link to further information, or describe within the policy if you intend to set and use cookies, tracking and similar technologies to store and manage user preferences on your website, advertise, enable content or otherwise analyse user and usage data. Provide information on what types of cookies and technologies you use, why you use them and how an individual can control and manage them. &lt;br&gt; &lt;br&gt;Linking to other websites / third party content &lt;br&gt;If you link to external sites and resources from your website, be specific on whether this constitutes endorsement, and if you take any responsibility for the content (or information contained within) any linked website. &lt;br&gt;&lt;br&gt;You may wish to consider adding other optional clauses to your privacy policy, depending on your business’ circumstances.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '&lt;h4&gt;1- Write about your website here.&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &lt;br&gt;&lt;br&gt; &lt;h4&gt;2- Random title&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dxzcolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '&lt;h4&gt;1- Refund Page .&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &lt;br&gt;&lt;br&gt; &lt;h4&gt;2- Random title&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dxzcolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Shorts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'The maximum video duration allowed is {D} seconds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Amount is empty');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'SecurionPay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Authorize.Net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Ngenius');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Coinpayments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Your payment using CoinPayments has been canceled');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Your payment using CoinPayments has been approved');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'You don&#039;t have enough balance to purchase, please top up your wallet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Pay By Wallet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'You are about to upgrade to a PRO memeber.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Payment successfully done, thank you!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'You are about to subscribe.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'You are about to purchase video.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'You are about to rent video.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Too many login attempts please try again later');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'Remember this device');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Must be at least 6 characters long.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Must contain a lowercase letter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Must contain an uppercase letter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Must contain a number or special character.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'The password supplied does not meet the minimum complexity requirements.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Your First Name and Last Name can not be empty.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Invitation Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Unlimited');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Available Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Generated Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Used Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Generate Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Code successfully generated');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Copied');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'Url');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Invited User');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Please note that maximum duration allow is {X} seconds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Cut The Video');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'terms_of_use_page', '&lt;h4&gt;1- Write your Terms Of Use here.&lt;/h4&gt; &lt;br&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &lt;br&gt;&lt;br&gt; &lt;h4&gt;2- Random title&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'privacy_policy_page', '&lt;h2&gt;Who we are?&lt;/h2&gt;Provide name and contact details of the data controller. This will typically be your business or you, if you are a sole trader. Where applicable, you should include the identity and contact details of the controller’s representative and/or the data protection officer. &lt;br&gt;&lt;h2&gt;What information do we collect?&lt;/h2&gt; Specify the types of personal information you collect, eg names, addresses, user names, etc. You should include specific details on: &lt;br&gt;how you collect data (eg when a user registers, purchases or uses your services, completes a contact form, signs up to a newsletter, etc) &lt;br&gt;what specific data you collect through each of the data collection method &lt;br&gt;if you collect data from third parties, you must specify categories of data and source &lt;br&gt;if you process sensitive personal data or financial information, and how you handle this &lt;br&gt;&lt;br&gt;You may want to provide the user with relevant definitions in relation to personal data and sensitive personal data. &lt;br&gt;&lt;br&gt;&lt;h2&gt;How do we use personal information?&lt;/h2&gt;Describe in detail all the service- and business-related purposes for which you will process data. For example, this may include things like: &lt;br&gt;personalisation of content, business information or user experience &lt;br&gt;account set up and administration &lt;br&gt;delivering marketing and events communication &lt;br&gt;carrying out polls and surveys &lt;br&gt;internal research and development purposes &lt;br&gt;providing goods and services &lt;br&gt;legal obligations (eg prevention of fraud) &lt;br&gt;meeting internal audit requirements &lt;br&gt;&lt;br&gt;Please note this list is not exhaustive. You will need to record all purposes for which you process personal data. &lt;br&gt; &lt;br&gt;&lt;h2&gt;What legal basis do we have for processing your personal data?&lt;/h2&gt;Describe the relevant processing conditions contained within the GDPR. There are six possible legal grounds: &lt;br&gt;consent &lt;br&gt;contract &lt;br&gt;legitimate interests &lt;br&gt;vital interests &lt;br&gt;public task &lt;br&gt;legal obligation &lt;br&gt;&lt;br&gt;Provide detailed information on all grounds that apply to your processing, and why. If you rely on consent, explain how individuals can withdraw and manage their consent. If you rely on legitimate interests, explain clearly what these are. &lt;br&gt; &lt;br&gt;If you’re processing special category personal data, you will have to satisfy at least one of the six processing conditions, as well as additional requirements for processing under the GDPR. Provide information on all additional grounds that apply. &lt;br&gt; &lt;br&gt;&lt;h2&gt;When do we share personal data?&lt;/h2&gt;Explain that you will treat personal data confidentially and describe the circumstances when you might disclose or share it. Eg, when necessary to provide your services or conduct your business operations, as outlined in your purposes for processing. You should provide information on: &lt;br&gt;how you will share the data &lt;br&gt;what safeguards you will have in place &lt;br&gt;what parties you may share the data with and why &lt;br&gt; &lt;br&gt;&lt;h2&gt;Where do we store and process personal data?&lt;/h2&gt; If applicable, explain if you intend to store and process data outside of the data subject’s home country. Outline the steps you will take to ensure the data is processed according to your privacy policy and the applicable law of the country where data is located. &lt;br&gt; &lt;br&gt;If you transfer data outside the European Economic Area, outline the measures you will put in place to provide an appropriate level of data privacy protection. Eg contractual clauses, data transfer agreements, etc. &lt;br&gt; &lt;br&gt;&lt;h2&gt;How do we secure personal data?&lt;/h2&gt; Describe your approach to data security and the technologies and procedures you use to protect personal information. For example, these may be measures: &lt;br&gt;to protect data against accidental loss &lt;br&gt;to prevent unauthorised access, use, destruction or disclosure &lt;br&gt;to ensure business continuity and disaster recovery &lt;br&gt;to restrict access to personal information &lt;br&gt;to conduct privacy impact assessments in accordance with the law and your business policies &lt;br&gt;to train staff and contractors on data security &lt;br&gt;to manage third party risks, through use of contracts and security reviews &lt;br&gt; &lt;br&gt;Please note this list is not exhaustive. You should record all mechanisms you rely on to protect personal data. You should also state if your organisation adheres to certain accepted standards or regulatory requirements. &lt;br&gt; &lt;br&gt;&lt;h2&gt;How long do we keep your personal data for?&lt;/h2&gt; &lt;br&gt;Provide specific information on the length of time you will keep the information for in relation to each processing purpose. The GDPR requires you to retain data for no longer than reasonably necessary. Include details of your data or records retention schedules, or link to additional resources where these are published. &lt;br&gt; &lt;br&gt;If you cannot state a specific period, you need to set out the criteria you will apply to determine how long to keep the data for (eg local laws, contractual obligations, etc) &lt;br&gt; &lt;br&gt;You should also outline how you securely dispose of data after you no longer need it. &lt;br&gt;&lt;br&gt;&lt;h2&gt;Your rights in relation to personal data&lt;/h2&gt; Under the GDPR, you must respect the right of data subjects to access and control their personal data. In your privacy notice, you must outline their rights in respect of: &lt;br&gt;access to personal information &lt;br&gt;correction and deletion &lt;br&gt;withdrawal of consent (if processing data on condition of consent) &lt;br&gt;data portability &lt;br&gt;restriction of processing and objection &lt;br&gt;lodging a complaint with the Information Commissioner’s Office &lt;br&gt; &lt;br&gt;You should explain how individuals can exercise their rights, and how you plan to respond to subject data requests. State if any relevant exemptions may apply and set out any identity verification procedures you may rely on. &lt;br&gt; &lt;br&gt;Include details of the circumstances where data subject rights may be limited, eg if fulfilling the data subject request may expose personal data about another person, or if you’re asked to delete data which you are required to keep by law. &lt;br&gt; &lt;br&gt;&lt;h2&gt;Use of automated decision-making and profiling&lt;/h2&gt; Where you use profiling or other automated decision-making, you must disclose this in your privacy policy. In such cases, you must provide details on existence of any automated decision-making, together with information about the logic involved, and the likely significance and consequences of the processing of the individual. &lt;br&gt; &lt;br&gt;&lt;h2&gt;How to contact us?&lt;/h2&gt; Explain how data subject can get in touch if they have questions or concerns about your privacy practices, their personal information, or if they wish to file a complaint. Describe all ways in which they can contact you – eg online, by email or postal mail. &lt;br&gt;&gt; &lt;br&gt;If applicable, you may also include information on: &lt;br&gt; &lt;br&gt;&lt;h2&gt;Use of cookies and other technologies&lt;/h2&gt; You may include a link to further information, or describe within the policy if you intend to set and use cookies, tracking and similar technologies to store and manage user preferences on your website, advertise, enable content or otherwise analyse user and usage data. Provide information on what types of cookies and technologies you use, why you use them and how an individual can control and manage them. &lt;br&gt; &lt;br&gt;Linking to other websites / third party content &lt;br&gt;If you link to external sites and resources from your website, be specific on whether this constitutes endorsement, and if you take any responsibility for the content (or information contained within) any linked website. &lt;br&gt;&lt;br&gt;You may wish to consider adding other optional clauses to your privacy policy, depending on your business’ circumstances.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'about_page', '&lt;h4&gt;1- Write about your website here.&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &lt;br&gt;&lt;br&gt; &lt;h4&gt;2- Random title&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dxzcolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'refund_terms_page', '&lt;h4&gt;1- Refund Page .&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &lt;br&gt;&lt;br&gt; &lt;h4&gt;2- Random title&lt;/h4&gt; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dxzcolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts', 'Shorts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_video_duration', 'The maximum video duration allowed is {D} seconds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'empty_amount', 'Amount is empty');
            $lang_update_queries[] = PT_UpdateLangs($value, 'securionpay', 'SecurionPay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'authorize', 'Authorize.Net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yoomoney', 'Yoomoney');
            $lang_update_queries[] = PT_UpdateLangs($value, 'fortumo', 'Fortumo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinbase', 'Coinbase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ngenius', 'Ngenius');
            $lang_update_queries[] = PT_UpdateLangs($value, 'aamarpay', 'Aamarpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments', 'Coinpayments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_canceled', 'Your payment using CoinPayments has been canceled');
            $lang_update_queries[] = PT_UpdateLangs($value, 'coinpayments_approved', 'Your payment using CoinPayments has been approved');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_top_up_wallet', 'You don&#039;t have enough balance to purchase, please top up your wallet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_from_wallet', 'Pay By Wallet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_upgrade', 'You are about to upgrade to a PRO memeber.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_successfully_done', 'Payment successfully done, thank you!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_subscribe', 'You are about to subscribe.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_video', 'You are about to purchase video.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_rent_video', 'You are about to rent video.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_attempts', 'Too many login attempts please try again later');
            $lang_update_queries[] = PT_UpdateLangs($value, 'remember_device', 'Remember this device');
            $lang_update_queries[] = PT_UpdateLangs($value, 'least_characters', 'Must be at least 6 characters long.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_lowercase', 'Must contain a lowercase letter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contain_uppercase', 'Must contain an uppercase letter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'number_special', 'Must contain a number or special character.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'complexity_requirements', 'The password supplied does not meet the minimum complexity requirements.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'first_name_last_name_empty', 'Your First Name and Last Name can not be empty.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invitation_links', 'Invitation Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unlimited', 'Unlimited');
            $lang_update_queries[] = PT_UpdateLangs($value, 'available_links', 'Available Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generated_links', 'Generated Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'used_links', 'Used Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_link', 'Generate Links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'code_successfully', 'Code successfully generated');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copy', 'Copy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'copied', 'Copied');
            $lang_update_queries[] = PT_UpdateLangs($value, 'url', 'Url');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invited_user', 'Invited User');
            $lang_update_queries[] = PT_UpdateLangs($value, 'date', 'Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'shorts_maximum_duration_allow', 'Please note that maximum duration allow is {X} seconds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'crop_the_video', 'Cut The Video');
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
                     <h2 class="light">Update to v2.2 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                          <li>[Added] the ability to translate terms pages.</li>
                          <li>[Added] the ability to edit every page's SEO.</li>
                          <li>[Added] wasabi storage.</li>
                          <li>[Added] shorts videos, (youtube short videos).</li>
                          <li>[Added] the ability to prevent bad login attempts.</li>
                          <li>[Added] the ability to remember this device.</li>
                          <li>[Added] password complexity system.</li>
                          <li>[Added] registeration by first and last name (auto generated username).</li>
                          <li>[Added] user invitation system.</li>
                          <li>[Added] converted all payments system to one wallet.</li>
                          <li>[Added] added securionpay, Authorize.Net, Yoomoney, Fortumo, Coinbase, Aamarpay, Ngenius and CoinPayments payment methods.</li>
                          <li>[Added] new API.</li>
                          <li>[Updated] documentation.</li>
                          <li>[Fixed] few bugs. </li>
                          <li>[Fixed] small XSS vulnerability.</li>
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
    "UPDATE `config` SET `value` = '2.2' WHERE `name` = 'version';",

    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_storage', 'off');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_bucket_name', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_access_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_secret_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_bucket_region', 'us-west-1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'seo', '{\"404\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"ads\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"ads_analytics\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"age_block\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"articles\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"comments\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"confirm\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"contact\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"create_ads\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"create_article\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"create_post\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"dashboard\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"edit-video\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"edit_activity\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"edit_ads\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"edit_articles\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"embed\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"forgot_password\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"get-video-comments\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"go_pro\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"history\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"home\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"import-video\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"import-video-api\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"liked-videos\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"live\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"login\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"logout\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"maintenance\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"manage-videos\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"messages\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"movies\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"my_articles\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"paid-videos\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"popular_channels\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"post\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"read\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"redirect\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"register\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"resend\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"reset-password\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"saved-videos\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"search\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"settings\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"site-pages\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"subscriptions\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"terms\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"timeline\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"transactions\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"two_factor_login\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"two_factor_submit\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"upload-api\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"upload-video\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"video_studio\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"video_text\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"videos\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"view_analytics\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"},\"watch\":{\"title\":\"playtube\",\"meta_keywords\":\"playtube,video sharing\",\"meta_description\":\"PlayTube is a PHP Video Sharing Script, PlayTube is the best way to start your own video sharing script!\"}}');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'shorts_system', 'on');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'shorts_duration', '15');",
    "ALTER TABLE `videos` ADD `is_short` INT(11) NOT NULL DEFAULT '0' AFTER `publication_date`, ADD INDEX (`is_short`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'date_style', 'm/d/y');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paypal', 'no');",
    "ALTER TABLE `users` ADD `StripeSessionId` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `linkedIn`, ADD INDEX (`StripeSessionId`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'securionpay_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'securionpay_public_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'securionpay_secret_key', '');",
    "ALTER TABLE `users` ADD `securionpay_key` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `StripeSessionId`, ADD INDEX (`securionpay_key`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_test_mode', 'SANDBOX');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_login_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'authorize_transaction_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'yoomoney_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'yoomoney_wallet_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'yoomoney_notifications_secret', '');",
    "ALTER TABLE `users` ADD `yoomoney_hash` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `securionpay_key`, ADD INDEX (`yoomoney_hash`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'fortumo_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'fortumo_service_id', '');",
    "ALTER TABLE `users` ADD `fortumo_hash` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `yoomoney_hash`, ADD INDEX (`fortumo_hash`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinbase_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinbase_key', '');",
    "ALTER TABLE `users` ADD `coinbase_hash` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `fortumo_hash`, ADD INDEX (`coinbase_hash`);",
    "ALTER TABLE `users` ADD `coinbase_code` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `coinbase_hash`, ADD INDEX (`coinbase_code`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'ngenius_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'ngenius_mode', 'sandbox');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'ngenius_api_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'ngenius_outlet_id', '');",
    "ALTER TABLE `users` ADD `ngenius_ref` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `coinbase_code`, ADD INDEX (`ngenius_ref`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'aamarpay_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'aamarpay_mode', 'sandbox');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'aamarpay_store_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'aamarpay_signature_key', '');",
    "ALTER TABLE `users` ADD `aamarpay_tran_id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `ngenius_ref`, ADD INDEX (`aamarpay_tran_id`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments_secret', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments_public_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments_coin', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'coinpayments_coins', '');",
    "ALTER TABLE `users` ADD `coinpayments_txn_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `aamarpay_tran_id`, ADD INDEX (`coinpayments_txn_id`);",
    "ALTER TABLE `users` ADD `pause_history` INT(2) NOT NULL DEFAULT '0' AFTER `coinpayments_txn_id`, ADD INDEX (`pause_history`);",
    "CREATE TABLE `video_time` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `video_id` INT(11) NOT NULL DEFAULT '0' , `time` VARCHAR(50) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`video_id`), INDEX (`time`)) ENGINE = InnoDB;",
    "ALTER TABLE `users` ADD `tv_code` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `pause_history`, ADD INDEX (`tv_code`);",
    "CREATE TABLE `not_interested` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `video_id` INT(11) NOT NULL DEFAULT '0' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`video_id`), INDEX (`time`)) ENGINE = InnoDB;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'prevent_system', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'bad_login_limit', '4');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'lock_time', '10');",
    "CREATE TABLE `bad_login` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `ip` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`ip`), INDEX (`time`)) ENGINE = InnoDB;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'remember_device', '1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'password_complexity_system', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'auto_username', 'off');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'invite_links_system', 'off');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'user_links_limit', '10');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'expire_user_links', 'month');",
    "CREATE TABLE `invitation_links` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `invited_id` INT(11) NOT NULL DEFAULT '0' , `code` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`invited_id`), INDEX (`code`), INDEX (`time`)) ENGINE = InnoDB;",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'terms_of_use_page');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'privacy_policy_page');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'about_page');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'refund_terms_page');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'shorts');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'max_video_duration');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'empty_amount');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'securionpay');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'authorize');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'yoomoney');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'fortumo');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'coinbase');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ngenius');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'aamarpay');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'coinpayments');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'coinpayments_canceled');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'coinpayments_approved');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'please_top_up_wallet');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_from_wallet');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_upgrade');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'payment_successfully_done');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_subscribe');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_rent_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'login_attempts');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'remember_device');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'least_characters');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'contain_lowercase');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'contain_uppercase');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'number_special');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'complexity_requirements');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'first_name_last_name_empty');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'invitation_links');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'unlimited');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'available_links');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'generated_links');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'used_links');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'generate_link');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'code_successfully');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'copy');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'copied');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'url');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'invited_user');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'date');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'shorts_maximum_duration_allow');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'crop_the_video');",
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
