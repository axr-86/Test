<?php

namespace Sprint\Migration;


class Version20200127111111 extends Version
{
    protected $description = "Создание инфоблока \"Список мероприятий\"";

    protected $moduleVersion = "3.12.17";

    public function up()
    {
	    $helper = $this->getHelperManager();

	    $helper->Iblock()->getIblockTypeIdIfExists('events');

	    $iblockEventsList = $helper->Iblock()->saveIblock([
		    'NAME' => 'Список мероприятий',
		    'CODE' => 'events_list',
		    'LID' => ['s1'],
		    'IBLOCK_TYPE_ID' => 'events',
		    'LIST_PAGE_URL' => '#SITE_DIR#/events/',
		    'DETAIL_PAGE_URL' => '#SITE_DIR#/events/#ELEMENT_CODE#',
	    ]);

	    $helper->Iblock()->saveIblockFields($iblockEventsList, [
		    'CODE' => [
			    'IS_REQUIRED' => 'Y',
			    'DEFAULT_VALUE' => [
				    'TRANSLITERATION' => 'Y',
				    'UNIQUE' => 'Y',
				    'TRANS_SPACE' => '_',
				    'TRANS_OTHER' => '_',
			    ],
		    ],
	    ]);

	    $this->outSuccess('Инфоблок создан');

    }

    public function down()
    {
	    $helper = $this->getHelperManager();
	    $ok = $helper->Iblock()->deleteIblockIfExists('events_list');

	    if ($ok) {
		    $this->outSuccess('Инфоблоки удалены');
	    } else {
		    $this->outError('Ошибка удаления инфоблока');
	    }

    }

}
