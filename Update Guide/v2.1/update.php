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
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'يوسع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'حسابي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'لعب');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'عناصر قائمة التشغيل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'تسجيل الدخول مع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'يساعد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'دردشة واضحة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'تفاصيل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'عناصر الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'الرؤية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'خطوات واحدة تحميل الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 خطوات تحميل الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'سحب وإسقاط ملفات الفيديو لتحميل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'ستكون مقاطع الفيديو الخاصة بك خاصة حتى تنشرها.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'استخدام عنوان URL للفيديو واستيراد الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'الخطوة التالية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'ماذا تفعل تحميل؟');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'عد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'تحميل الفيديو كاملة. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'رابط الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'اسم الملف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'حدد أو تحميل صورة توضح ما هو في الفيديو الخاص بك. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'يمكنك تحميل مقطورة لفيلمك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'أضف علامات إلى الفيديو الخاص بك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'أضف فئة فرعية إلى الفيديو الخاص بك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'إضافة فئة إلى الفيديو الخاص بك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'اختيار خصوصية الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'تحميل الفيديو العادي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'تحميل فيلم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'حمل فيديو الأسهم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'الحظر الجغرافي');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Uitbreiden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'Mijn rekening');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Toneelstuk');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Afspeellijstitems');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Login met');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Hulp');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Wissen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Video-elementen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Zichtbaarheid');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'Eén stappen Video Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 stappen video-upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Sleep videobestanden naar uploaden en neerzetten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Je video\'s zijn privé totdat je ze publiceert.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Gebruik Video-URL en importeer video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Volgende stap');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'Wat upload je?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Ga terug');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Video-upload compleet. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Video link');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'Bestandsnaam');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Selecteer of upload een foto die laat zien wat er in uw video staat. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'U kunt een trailer uploaden voor uw film.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Tags toevoegen aan je video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Voeg subcategorie toe aan uw video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Voeg categorie toe aan uw video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Kies de videoprivacy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Upload een normale video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Upload een film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Upload een stockvideo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo-blokkering');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Développer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'Mon compte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Jouer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Articles de playlist');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Connectez-vous avec');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Aider');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Chat clair');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Détails');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Éléments vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Visibilité');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'Un téléchargement vidéo d\'une étape');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 étapes Téléchargement de vidéos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Faites glisser et déposer des fichiers vidéo pour télécharger');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Vos vidéos seront privées jusqu\'à ce que vous les publiez.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Utilisez URL vidéo et importer une vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'L\'étape suivante');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'Que téléchargez-vous?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Retourner');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Téléchargement de vidéos complète. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Lien vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'Nom de fichier');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Sélectionnez ou téléchargez une image qui indique ce qui est dans votre vidéo. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'Vous pouvez télécharger une remorque pour votre film.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Ajouter des tags à votre vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Ajouter une catégorie à votre vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Ajouter une catégorie à votre vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Choisissez la vidéo Confidentialité');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Téléchargez une vidéo normale');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Télécharger un film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Télécharger une vidéo en stock');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Géolocalisation');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Erweitern');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'Mein Konto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Spielen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Playlist-Artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Einloggen mit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Hilfe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Chat löschen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Einzelheiten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Videoelemente');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Sichtweite');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'Ein Schritten Video-Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 Schritte Video-Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Drehen Sie Videodateien, um das Upload zu hochzuladen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Ihre Videos sind privat, bis Sie sie veröffentlichen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Verwenden Sie Video-URL und importieren Sie Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Nächster Schritt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'Was machst du hoch?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Geh zurück');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Video-Upload komplett. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Video-Link');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'Dateinamen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Wählen Sie ein Bild aus, das zeigt, was in Ihrem Video in Ihrem Video ist. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'Sie können einen Trailer für Ihren Film hochladen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Fügen Sie Ihrem Video Tags hinzu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Fügen Sie Ihrem Video Unterkategorie hinzu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Fügen Sie Ihrem Video Kategorie hinzu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Wählen Sie das Video-Datenschutz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Laden Sie ein normales Video hoch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Laden Sie einen Film hoch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Laden Sie ein Stock Video hoch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo-Blockierung');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Расширять');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'Мой счет');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Играть');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Элементы плейлиста');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Зайдите в учетную запись, используя');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Помощь');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Чистый чат');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Подробности');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Видеоэлементы');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Видимость');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'Один шагов видео загрузка');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 шагов видео загрузка');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Перетащите видеофайлы для загрузки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Ваши видео будут частными, пока вы не опублилируете их.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Используйте видео URL и импорт видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Следующий шаг');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'Что ты загружаешь?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Вернись');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Загрузить видео загрузку. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Видео ссылка');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'Имя файла');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Выберите или загрузите изображение, которое показывает, что в вашем видео. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'Вы можете загрузить трейлер для вашего фильма.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Добавить теги на ваше видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Добавьте подпунктивную категорию на ваше видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Добавить категорию на ваше видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Выберите конфиденциальность видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Загрузить нормальное видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Загрузить фильм');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Загрузить акции видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Геоблокировка');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Expandir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'Mi cuenta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Tocar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Artículos de lista de reproducción');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Iniciar con');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Ayuda');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Vacie la conversacion');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Detalles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Elementos de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Visibilidad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'Subir video de un paso');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 pasos de video Subir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Arrastrar y soltar archivos de video para subir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Tus videos serán privados hasta que los publique.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Usa la URL de video e importar video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Próximo paso');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', '¿Qué estás subiendo?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Regresa');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Carga de video completa. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Enlace de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'Nombre del archivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Seleccione o cargue una imagen que muestre lo que hay en su video. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'Puedes subir un trailer para tu película.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Añadir etiquetas a tu video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Agregue la subcategoría a su video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Añadir categoría a su video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Elige la privacidad de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Sube un video normal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Subir una película');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Sube un almacen de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Bloqueo geográfico');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Genişletmek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'Hesabım');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Oyna');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Çalma listesi öğeleri');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'İle giriş');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Yardım');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Sohbeti temizle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Detaylar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Video öğeleri');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Görünürlük');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'Bir adım video yükleme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 Adım Video Yükleme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Yüklemek için video dosyalarını sürükleyip bırakın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Videoları yayınlayana kadar videolarınız özel olacak.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Video URL\'si kullanın ve video içe aktarın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Sonraki adım');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'Ne yükliyorsun?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Geri gitmek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Video yükleme tamamlandı. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Video bağlantısı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'Dosya adı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Videonuzda ne olduğunu gösteren bir resim seçin veya yükleyin. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'Filminiz için bir römork yükleyebilirsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Videonuza Etiketler Ekleyin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Videonuza Alt Kategori Ekle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Videonuza kategori ekle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Video gizliliğini seçin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Normal bir video yükle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Bir film yükle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Bir stok video yükle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Coğrafi engelleme');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Expand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'My Account');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Play');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Playlist Items');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Login with');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Help');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Clear Chat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Video Elements');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Visibility');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'One Steps Video Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 Steps Video Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Drag and drop video files to upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Your videos will be private until you publish them.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Use Video URL and Import Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Next Step');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'What are you uploading?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Go Back');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Video upload complete. No issues found.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Video Link');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'File Name');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Select or upload a picture that shows what\'s in your video. A good thumbnail stands out and draws viewers\' attention');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'You can upload a trailer for your movie.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Add tags to your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Add sub category to your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Add category to your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Choose the video privacy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Upload a normal video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Upload a movie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Upload a stock video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo-Blocking');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'expand', 'Expand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_account', 'My Account');
            $lang_update_queries[] = PT_UpdateLangs($value, 'vid_play', 'Play');
            $lang_update_queries[] = PT_UpdateLangs($value, 'play_list_item', 'Playlist Items');
            $lang_update_queries[] = PT_UpdateLangs($value, 'login_with', 'Login with');
            $lang_update_queries[] = PT_UpdateLangs($value, 'contact_help', 'Help');
            $lang_update_queries[] = PT_UpdateLangs($value, 'clear_chat', 'Clear Chat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_details', 'Details');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_elements', 'Video Elements');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_visibility', 'Visibility');
            $lang_update_queries[] = PT_UpdateLangs($value, 'import_subhead', 'One Steps Video Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_subhead', '3 Steps Video Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'darg_drop_to_upload', 'Drag and drop video files to upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_will_private', 'Your videos will be private until you publish them.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'use_url_import', 'Use Video URL and Import Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'next_step', 'Next Step');
            $lang_update_queries[] = PT_UpdateLangs($value, 'what_you_uploading', 'What are you uploading?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_back', 'Go Back');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_video_issue', 'Video upload complete. No issues found.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_link', 'Video Link');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_name', 'File Name');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_thumb_desc', 'Select or upload a picture that shows what\'s in your video. A good thumbnail stands out and draws viewers\' attention');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_trailer_desc', 'You can upload a trailer for your movie.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_tags_to_your_video', 'Add tags to your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_sub_category_to_your_video', 'Add sub category to your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_category_to_your_video', 'Add category to your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_the_video_privacy', 'Choose the video privacy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_video_text', 'Upload a normal video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_movie_text', 'Upload a movie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_normal_stock_video_text', 'Upload a stock video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo-Blocking');
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
                     <h2 class="light">Update to v2.1 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                               <li>[Added] new theme, updated youplay theme.</li>
                               <li>[Re-orginzed] admin panel links, content, texts and created auto save system.</li>
                               <li>[Added] new video player, plyr.io </li>
                               <li>[Fixed] 10+ reported bugs. </li>
                               <li>[Fixed] Important security bug. </li>
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
    "UPDATE `config` SET `value` = '2.1' WHERE `name` = 'version';",
    "ALTER TABLE `subscriptions` ADD `notify` INT(11) NOT NULL DEFAULT '1' AFTER `active`, ADD INDEX (`notify`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'agora_app_certificate', '');",
    "ALTER TABLE `videos` ADD `agora_token` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `agora_sid`;",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'expand');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'my_account');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'vid_play');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'play_list_item');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'login_with');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'contact_help');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'clear_chat');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_details');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_elements');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_visibility');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'import_subhead');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_subhead');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'darg_drop_to_upload');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'videos_will_private');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'use_url_import');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'next_step');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'what_you_uploading');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'go_back');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_video_issue');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_link');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'file_name');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_video_thumb_desc');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_video_trailer_desc');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'add_tags_to_your_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'add_sub_category_to_your_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'add_category_to_your_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'choose_the_video_privacy');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_normal_video_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_normal_movie_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_normal_stock_video_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'geo_blocking');",
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