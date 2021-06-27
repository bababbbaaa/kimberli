<?php
$nazva_lida = "Test text"; // Назва ліда
$zvernennya = "HNR_UA_2"; // Звернення (Можливі значення: "HNR_UA_1" = Пане, "HNR_UA_2" = Пані)
$Іm_ya = "Test text"; // Ім"я
$po_batkovi = "Test text"; // По батькові
$prizvische = "Test text"; // Прізвище
$data_narodjennya = "05.11.2020"; // Дата народження (формат дата)
$nazva_kompaniї = "Test text"; // Назва компанії
$djerelo = "7"; // Джерело (Можливі значення: "8" = ---, "CALL" = ОБЗВОН, "EMAIL" = Електронна пошта, "ADVERTISING" = Реклама, "PARTNER" = входящий звонок с сайта/запрос по телефону, "RECOMMENDATION" = По рекомендації ИО, "TRADE_SHOW" = Виставка, "WEBFORM" = Трафик магазина Океан Плаза, "CALLBACK" = Зворотний дзвінок з ремонтами, "RC_GENERATOR" = Генератор продажів, "STORE" = оформленный заказ, Інтернет-магазин, "2|FACEBOOK" = Facebook, "2|TELEGRAM" = Telegram - Відкрита лінія VIBER, "2|FACEBOOKCOMMENTS" = Facebook: Коментарі - Відкрита лінія VIBER, "2|INSTAGRAM" = Instagram, "2|VIBER" = Viber, "6" = ТЕЛЕГРАММ, "2|OPENLINE" = Онлайн-чат на сайте, "4" = розетка, "5" = ЛАМОДА, "7" = внутренний покупатель)
$dodatkovo_pro_djerelo = "Test text"; // Додатково про джерело
$status = "JUNK"; // Статус (Можливі значення: "NEW" = первичное касание, "3" = Обработанные звонки, "7" = повторный обработанный лид, "IN_PROCESS" = Презентация продукта, "4" = отложенный спрос, "6" = коммандировка, "1" = Клиент принимает решение, "PROCESSED" = Ценовое предложение, "2" = Сделка/заказ/счет на оплату, "CONVERTED" = Якісний лід, "JUNK" = Неякісний лід)
$dodatkovo_pro_status = "Test text"; // Додатково про статус
$posada = "Test text"; // Посада
$adresa = "Test text"; // Адреса
$adresa_str2 = "Test text"; // Адреса (стр. 2)
$misto = "Test text"; // Місто
$oblast = "Test text"; // Область
$kraїna = "Test text"; // Країна
$kod_kraїni = "Test text"; // Код країни
$Іdentifikator_adresi_mistseznahodjennya = 99; // Ідентифікатор адреси місцезнаходження
$valyuta = "EUR"; // Валюта (Можливі значення: UAH, RUB, USD, EUR)
$suma = 99; // Сума
$dostupniy_dlya_vsih = "Y"; // Доступний для всіх (Можливі значення: Y - Так, N - Ні)
$komentar = "Test text"; // Коментар
$vidpovidalniy = 1; // Відповідальний (ID користувача)
$kompaniya = 20; // Компанія (ID компанії)
$kontakt = 20; // Контакт (ID контакту)
$zovnishnє_djerelo = "Test text"; // Зовнішнє джерело
$Іdentifikator_elementa_v_zovnishnomu_djereli = "Test text"; // Ідентифікатор елемента в зовнішньому джерелі
$reklamna_sistema = "Test text"; // Рекламна система
$tip_trafiku = "Test text"; // Тип трафіку
$poznachennya_reklamnoї_kampaniї = "Test text"; // Позначення рекламної кампанії
$zmist_kampaniї = "Test text"; // Зміст кампанії
$umova_poshuku_kampaniї = "Test text"; // Умова пошуку кампанії
$telefon = "+380933333333"; // Телефон
$e_mail = "test@gmail.com"; // E-mail (формат email)
$sayt = "facebook.com"; // Сайт (посилання на сайт)
$mesendjer = "facebook"; // Месенджер (id акаунта)
$byudjet_klienta = ""; // Бюджет клиента
$tip_klienta = 168; // Тип клиента (Можливі значення: "166" = Опт, "168" = Розница)

file_get_contents("https://leads.devrise.com.ua/lead_add.php" .
      "?token=adc76c792dde5305f95adf91d17d9a" .
      "&TITLE=" . urlencode($nazva_lida) .
      "&HONORIFIC=" . urlencode($zvernennya) .
      "&NAME=" . urlencode($Іm_ya) .
      "&SECOND_NAME=" . urlencode($po_batkovi) .
      "&LAST_NAME=" . urlencode($prizvische) .
      "&BIRTHDATE=" . urlencode($data_narodjennya) .
      "&COMPANY_TITLE=" . urlencode($nazva_kompaniї) .
      "&SOURCE_ID=" . urlencode($djerelo) .
      "&SOURCE_DESCRIPTION=" . urlencode($dodatkovo_pro_djerelo) .
      "&STATUS_ID=" . urlencode($status) .
      "&STATUS_DESCRIPTION=" . urlencode($dodatkovo_pro_status) .
      "&POST=" . urlencode($posada) .
      "&ADDRESS=" . urlencode($adresa) .
      "&ADDRESS_2=" . urlencode($adresa_str2) .
      "&ADDRESS_CITY=" . urlencode($misto) .
      "&ADDRESS_PROVINCE=" . urlencode($oblast) .
      "&ADDRESS_COUNTRY=" . urlencode($kraїna) .
      "&ADDRESS_COUNTRY_CODE=" . urlencode($kod_kraїni) .
      "&ADDRESS_LOC_ADDR_ID=" . urlencode($Іdentifikator_adresi_mistseznahodjennya) .
      "&CURRENCY_ID=" . urlencode($valyuta) .
      "&OPPORTUNITY=" . urlencode($suma) .
      "&OPENED=" . urlencode($dostupniy_dlya_vsih) .
      "&COMMENTS=" . urlencode($komentar) .
      "&ASSIGNED_BY_ID=" . urlencode($vidpovidalniy) .
      "&COMPANY_ID=" . urlencode($kompaniya) .
      "&CONTACT_ID=" . urlencode($kontakt) .
      "&ORIGINATOR_ID=" . urlencode($zovnishnє_djerelo) .
      "&ORIGIN_ID=" . urlencode($Іdentifikator_elementa_v_zovnishnomu_djereli) .
      "&UTM_SOURCE=" . urlencode($reklamna_sistema) .
      "&UTM_MEDIUM=" . urlencode($tip_trafiku) .
      "&UTM_CAMPAIGN=" . urlencode($poznachennya_reklamnoї_kampaniї) .
      "&UTM_CONTENT=" . urlencode($zmist_kampaniї) .
      "&UTM_TERM=" . urlencode($umova_poshuku_kampaniї) .
      "&PHONE=" . urlencode($telefon) .
      "&EMAIL=" . urlencode($e_mail) .
      "&WEB=" . urlencode($sayt) .
      "&IM=" . urlencode($mesendjer) .
      "&UF_CRM_1591105679939=" . urlencode($byudjet_klienta) .
      "&UF_CRM_1591106755997=" . urlencode($tip_klienta)
);
/*
//Згенерований ajax запит
var nazva_lida = "Test text"; // Назва ліда
var zvernennya = "HNR_UA_2"; // Звернення (Можливі значення: "HNR_UA_1" = Пане, "HNR_UA_2" = Пані)
var Іm_ya = "Test text"; // Ім"я
var po_batkovi = "Test text"; // По батькові
var prizvische = "Test text"; // Прізвище
var data_narodjennya = "05.11.2020"; // Дата народження (формат дата)
var nazva_kompaniї = "Test text"; // Назва компанії
var djerelo = "7"; // Джерело (Можливі значення: "8" = ---, "CALL" = ОБЗВОН, "EMAIL" = Електронна пошта, "ADVERTISING" = Реклама, "PARTNER" = входящий звонок с сайта/запрос по телефону, "RECOMMENDATION" = По рекомендації ИО, "TRADE_SHOW" = Виставка, "WEBFORM" = Трафик магазина Океан Плаза, "CALLBACK" = Зворотний дзвінок з ремонтами, "RC_GENERATOR" = Генератор продажів, "STORE" = оформленный заказ, Інтернет-магазин, "2|FACEBOOK" = Facebook, "2|TELEGRAM" = Telegram - Відкрита лінія VIBER, "2|FACEBOOKCOMMENTS" = Facebook: Коментарі - Відкрита лінія VIBER, "2|INSTAGRAM" = Instagram, "2|VIBER" = Viber, "6" = ТЕЛЕГРАММ, "2|OPENLINE" = Онлайн-чат на сайте, "4" = розетка, "5" = ЛАМОДА, "7" = внутренний покупатель)
var dodatkovo_pro_djerelo = "Test text"; // Додатково про джерело
var status = "JUNK"; // Статус (Можливі значення: "NEW" = первичное касание, "3" = Обработанные звонки, "7" = повторный обработанный лид, "IN_PROCESS" = Презентация продукта, "4" = отложенный спрос, "6" = коммандировка, "1" = Клиент принимает решение, "PROCESSED" = Ценовое предложение, "2" = Сделка/заказ/счет на оплату, "CONVERTED" = Якісний лід, "JUNK" = Неякісний лід)
var dodatkovo_pro_status = "Test text"; // Додатково про статус
var posada = "Test text"; // Посада
var adresa = "Test text"; // Адреса
var adresa_str2 = "Test text"; // Адреса (стр. 2)
var misto = "Test text"; // Місто
var oblast = "Test text"; // Область
var kraїna = "Test text"; // Країна
var kod_kraїni = "Test text"; // Код країни
var Іdentifikator_adresi_mistseznahodjennya = 99; // Ідентифікатор адреси місцезнаходження
var valyuta = "EUR"; // Валюта (Можливі значення: UAH, RUB, USD, EUR)
var suma = 99; // Сума
var dostupniy_dlya_vsih = "Y"; // Доступний для всіх (Можливі значення: Y - Так, N - Ні)
var komentar = "Test text"; // Коментар
var vidpovidalniy = 1; // Відповідальний (ID користувача)
var kompaniya = 20; // Компанія (ID компанії)
var kontakt = 20; // Контакт (ID контакту)
var zovnishnє_djerelo = "Test text"; // Зовнішнє джерело
var Іdentifikator_elementa_v_zovnishnomu_djereli = "Test text"; // Ідентифікатор елемента в зовнішньому джерелі
var reklamna_sistema = "Test text"; // Рекламна система
var tip_trafiku = "Test text"; // Тип трафіку
var poznachennya_reklamnoї_kampaniї = "Test text"; // Позначення рекламної кампанії
var zmist_kampaniї = "Test text"; // Зміст кампанії
var umova_poshuku_kampaniї = "Test text"; // Умова пошуку кампанії
var telefon = "+380933333333"; // Телефон
var e_mail = "test@gmail.com"; // E-mail (формат email)
var sayt = "facebook.com"; // Сайт (посилання на сайт)
var mesendjer = "facebook"; // Месенджер (id акаунта)
var byudjet_klienta = ""; // Бюджет клиента
var tip_klienta = 168; // Тип клиента (Можливі значення: "166" = Опт, "168" = Розница)

$.ajax({
      url: "https://leads.devrise.com.ua/lead_add.php",
      type: "POST",
      data: {
            token: "adc76c792dde5305f95adf91d17d9a",
            TITLE: nazva_lida,
            HONORIFIC: zvernennya,
            NAME: Іm_ya,
            SECOND_NAME: po_batkovi,
            LAST_NAME: prizvische,
            BIRTHDATE: data_narodjennya,
            COMPANY_TITLE: nazva_kompaniї,
            SOURCE_ID: djerelo,
            SOURCE_DESCRIPTION: dodatkovo_pro_djerelo,
            STATUS_ID: status,
            STATUS_DESCRIPTION: dodatkovo_pro_status,
            POST: posada,
            ADDRESS: adresa,
            ADDRESS_2: adresa_str2,
            ADDRESS_CITY: misto,
            ADDRESS_PROVINCE: oblast,
            ADDRESS_COUNTRY: kraїna,
            ADDRESS_COUNTRY_CODE: kod_kraїni,
            ADDRESS_LOC_ADDR_ID: Іdentifikator_adresi_mistseznahodjennya,
            CURRENCY_ID: valyuta,
            OPPORTUNITY: suma,
            OPENED: dostupniy_dlya_vsih,
            COMMENTS: komentar,
            ASSIGNED_BY_ID: vidpovidalniy,
            COMPANY_ID: kompaniya,
            CONTACT_ID: kontakt,
            ORIGINATOR_ID: zovnishnє_djerelo,
            ORIGIN_ID: Іdentifikator_elementa_v_zovnishnomu_djereli,
            UTM_SOURCE: reklamna_sistema,
            UTM_MEDIUM: tip_trafiku,
            UTM_CAMPAIGN: poznachennya_reklamnoї_kampaniї,
            UTM_CONTENT: zmist_kampaniї,
            UTM_TERM: umova_poshuku_kampaniї,
            PHONE: telefon,
            EMAIL: e_mail,
            WEB: sayt,
            IM: mesendjer,
            UF_CRM_1591105679939: byudjet_klienta,
            UF_CRM_1591106755997: tip_klienta,
      },
      success: function(data){}
});
 * *
 */