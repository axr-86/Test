<?php

namespace Sprint\Migration;


class Version20200127000000 extends Version
{
    protected $description = "Создание типа инфоблоков \"Мероприятия\"";

    protected $moduleVersion = "3.12.17";

    public function up()
    {
	    $helper = $this->getHelperManager();

	    $helper->Iblock()->saveIblockType([
		    'ID' => 'events',
		    'LANG' => [
			    'en' => [
				    'NAME' => 'Events',
				    'SECTION_NAME' => 'Sections',
				    'ELEMENT_NAME' => 'Elements',
			    ],
			    'ru' => [
				    'NAME' => 'Мероприятия',
				    'SECTION_NAME' => 'Разделы',
				    'ELEMENT_NAME' => 'Элементы',
			    ],
		    ],
	    ]);

    }

    public function down()
    {
	    $helper = $this->getHelperManager();

	    $ok = $helper->Iblock()->deleteIblockTypeIfExists('events');

	    if ($ok) {
		    $this->outSuccess('Тип нфоблоков удален');
	    } else {
		    $this->outError('Ошибка удаления типа инфоблоков');
	    }

    }

}
