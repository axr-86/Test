<?php

namespace Sprint\Migration;


class Version20200127222222 extends Version
{
    protected $description = "Создание инфоблока \"Заявки на мероприятия\"";

    protected $moduleVersion = "3.12.17";

    public function up()
    {
	    $helper = $this->getHelperManager();

	    $helper->Iblock()->getIblockTypeIdIfExists('events');

	    $iblockEventsList = $helper->Iblock()->getIblockIdIfExists('events_list');

	    $iblockEventsRequests = $helper->Iblock()->saveIblock([
		    'NAME' => 'Заявки на мероприятия',
		    'CODE' => 'events_requests',
		    'LID' => ['s1'],
		    'IBLOCK_TYPE_ID' => 'events',
		    'LIST_PAGE_URL' => '',
		    'DETAIL_PAGE_URL' => '',
	    ]);

	    $helper->Iblock()->saveProperty($iblockEventsRequests, [
		    'NAME' => 'ФИО',
		    'CODE' => 'FIO',
		    'IS_REQUIRED' => 'Y',
	    ]);

	    $helper->Iblock()->saveProperty($iblockEventsRequests, [
		    'NAME' => 'Email',
		    'CODE' => 'EMAIL',
		    'IS_REQUIRED' => 'Y',
	    ]);

	    $helper->Iblock()->saveProperty($iblockEventsRequests, [
		    'NAME' => 'Телефон',
		    'CODE' => 'PHONE_NUMBER',
		    'IS_REQUIRED' => 'Y',
	    ]);

	    $helper->Iblock()->saveProperty($iblockEventsRequests, [
		    'NAME' => 'Мероприятия',
		    'CODE' => 'EVENTS_LIST',
		    'IS_REQUIRED' => 'Y',
		    'PROPERTY_TYPE' => 'E',
		    'USER_TYPE' => 'EList',
		    'MULTIPLE' => 'Y',
		    'LINK_IBLOCK_ID' => $iblockEventsList,
		    'USER_TYPE_SETTINGS' => [
			    'size' => 5,
			    'width' => 0,
			    'group' => 'N',
			    'multiple' => 'Y',
		    ],
	    ]);

	    $this->outSuccess('Инфоблок создан');

    }

    public function down()
    {
	    $helper = $this->getHelperManager();
	    $ok = $helper->Iblock()->deleteIblockIfExists('events_requests');

	    if ($ok) {
		    $this->outSuccess('Инфоблок удален');
	    } else {
		    $this->outError('Ошибка удаления инфоблока');
	    }

    }
}
