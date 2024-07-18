<?php

use AmoCRM\{AmoAPI, AmoLead, AmoIncomingLeadForm, AmoNote, AmoContact, AmoAPIException};
use AmoCRM\TokenStorage\TokenStorageException;

if ($_POST)
{

    require_once("amocrm/vendor/autoload.php");

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
    
    $subdomain = 'relocant';
    
    try {
        // Авторизация
        AmoAPI::oAuth2($subdomain);
    
        // Загрузка ВСЕХ контактов с возможностью фильтрации
        $generator = AmoAPI::getAllContacts([
            'query' => '+7' . substr(preg_replace("/[^0-9]/", '', $_POST['username']), -10)
        ]);
        foreach ($generator as $items) {
            foreach ($items as $item) {
                $contact = $item;
                break;
            }
            break;
        }
        
       
    
      if (isset($contact['id']) && (int) $contact['id'] != 0)
      {
        // update
        $contact1 = new AmoContact([
            'id'                  => $contact['id'],
            'name'                => 'Клиент '.$_POST['username'],
            'responsible_user_id' => $responseid,
        ]);
      } else {
        // Создание нового контакта
        $contact1 = new AmoContact([
            'name'                => $_POST['username'],
            'responsible_user_id' => $responseid,
        ]);  
        
        // Установка дополнительных полей
        $contact1->setCustomFields([
            '300037' => [[
                'value' => $_POST['username'],
                'enum'  => 'WORK'
            ]],
        ]);    
        
      }
      
    
    
        // Сохранение контакта и получение его ID
        $contact1Id = $contact1->save();
        
        // Создание новой сделки
        $lead1 = new AmoLead([
            'name'                => 'Заявка с сайта relocant.ae',
            'responsible_user_id' => $responseid,
            'pipeline'            => [ 'id' => 8122234 ],
            'status_id'           => 67610150,
            'sale'                => 0
       ]);
    

       if (isset($_POST['date1']) && !empty($_POST['date1']))
       {
            $dateText = 'Дата: '.$_POST['date1'].', Время: '.$_POST['date2'];
       } else {
            $dateText = '';
       }

        // Установка дополнительных полей
        $lead1->setCustomFields([
            '300051' => $utm['utm_source'],
            '300049' => $utm['utm_campaign'],
            '300047' => $utm['utm_medium'],
            '300045' => $utm['utm_content'],
            '300053' => $utm['utm_term'],
            '320893' => $dateText,
        ]);
    
        // Привязка контакта
        $lead1->addContacts($contact1Id);
    
        // Добавление тега
        $lead1->addTags('Заявка с сайта');
    
        // Сохранение сделки и получение ее ID
        $leadId = $lead1->save();
       
        // Создание нового события типа "обычное примечание", привязанного к сделке
        $note = new AmoNote([
            'element_id'   => $leadId,
            'note_type'    => AmoNote::COMMON_NOTETYPE,
            'element_type' => AmoNOTE::LEAD_TYPE,
            'text'         => '',
        ]);
    
        // Сохранение события и получение его ID
        //$noteId = $note->save();    
        
    } catch (AmoAPIException $e) {
        printf('Ошибка (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }   

}