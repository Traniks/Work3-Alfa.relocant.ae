<?php


use AmoCRM\{AmoAPI, AmoLead, AmoIncomingLeadForm, AmoContact, AmoAPIException};
use AmoCRM\TokenStorage\TokenStorageException;
if ($_POST)
{
require_once("vendor/autoload.php");

//utm по рефереру
$referer = $_SERVER['HTTP_REFERER'];
$arr = explode('?',$referer);
$arr = explode('&',$arr[1]);
$utm = array();
foreach($arr as $k=>$v)
{
 if (preg_match('/utm/i',$v))
 {
     $arr2 = explode('=', $v);
     $utm[$arr2[0]] = $arr2[1];
 }
} 
//
 
$responseid = 11002218;


$subdomain = 'relocantae';

$leadcf = array();

if (isset($_POST['date1']) && !empty($_POST['date1']))
{
    $leadcf = array(
        array(
            'id' => '320893', 
            'values' => array( 
                array(
                    'value' => 'Дата: '.$_POST['date1'].', Время: '.$_POST['date2'], 
                    'enum' => 'WORK',
                ),
            ),
        ),
    );
}

if (isset($utm['utm_source']) && !empty($utm['utm_source']))
{
    $leadcf[] = array(
        'id' => '300051', 
        'values' => array( 
            array(
                'value' => $utm['utm_source']
            ),
        ),
    );
}

if (isset($utm['utm_campaign']) && !empty($utm['utm_campaign']))
{
    $leadcf = array( 
        'id' => '300049', 'values' => array( array('value' => $utm['utm_campaign'])),
    );
}
if (isset($utm['utm_medium']) && !empty($utm['utm_medium']))
{
    $leadcf = array(
        'id' => '300047', 'values' => array( array('value' => $utm['utm_medium'])),
    );
}
if (isset($utm['utm_content']) && !empty($utm['utm_content']))
{
    $leadcf = array(
        'id' => '300045', 'values' => array( array('value' => $utm['utm_content'])),
    );
}
if (isset($utm['utm_term']) && !empty($utm['utm_term']))
{
    $leadcf = array(
        'id' => '300053', 'values' => array( array('value' => $utm['utm_term'])),
    );
}


try {
    // Авторизация
    AmoAPI::oAuth2($subdomain);

    // Создание новой сделки
    $lead1 = new AmoIncomingLeadForm([
        'source_name' => 'RELOCANT',
        'source_uid' => 'a1fee7c0fc436088e64ba2e8822ba2b3',
        'pipeline_id' => '8122234',
        'created_at' => time(),        
        'incoming_entities' => array(
            'leads' => array(
                    array(
                        'name' => 'Заявка с сайта test.sistemnik.online',
                        'created_at' => time(),
                        'status_id' => '66461810',
                        'responsible_user_id' => $responseid,
                        //'price' => '83000',
                        'tags' => 'Заявка с сайта',
                        'custom_fields' => $leadcf,
                    ),
            ),
        
            'contacts' => array(
                    array(
                        'name' => 'Клиент '.$_POST['username'],
                        'custom_fields' => array(
                            array(
                                'id' => '300037',
                                'values' => array(
                                    array(
                                        'value' => $_POST['username'],
                                        'enum' => 'WORK',
                                    ),
                                ),
                            ),
                        ),
                        'responsible_user_id' => $responseid,
                    ),
            ),
        ),
        'incoming_lead_info' => array(
                'form_id' => 667827,
                'created_at' => time(),
                'form_page' => 'https://relocant.ae/',
                
            ),

   ]);


    // Сохранение сделки и получение ее ID
    $leadId = $lead1->save();

} catch (AmoAPIException $e) {
    printf('Ошибка (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}

}