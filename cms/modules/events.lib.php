<?php
if(!defined('__PRAGYAN_CMS'))
{ 
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo "<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>";
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}
/**
 * @package pragyan
 * @copyright (c) 2008 Pragyan Team
 * @license http://www.gnu.org/licenses/ GNU Public License
 * For more details, see README
 */


class events implements module,fileuploadable {
	private $userId;
	private $moduleComponentId;
	public function getHtml($gotuid, $gotmoduleComponentId, $gotaction) {
		$this->userId = $gotuid;
		$this->moduleComponentId = $gotmoduleComponentId;
		if ($gotaction == 'csg')
			return $this->actionCsg();
		if ($gotaction == 'eventshead')
			return $this->actionEventshead();
		if ($gotaction == 'ochead')
			return $this->actionOchead();
		if ($gotaction == 'octeam')
			return $this->actionOcteam();
		if ($gotaction == 'qa')
			return $this->actionQa();
		if ($gotaction == 'pr')
			return $this->actionPr();
		if ($gotaction == 'view')
			return $this->actionView();
    /*    if ($gotaction == '')
	  return $this->actionAddroom();
    */
	  else return $this->actionView();
	}

	public function actionView(){
		global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
		$moduleComponentId=$this->moduleComponentId;
		$userId=$this->userId;
		$scriptFolder = "$sourceFolder/$moduleFolder/events/";
		require_once("$sourceFolder/$moduleFolder/events/events_common.php");
		if(isset($_GET['subaction'])){
			if($_GET['subaction']=="map"){
				return showEventMap();
			}
			if($_GET['subaction']=="mobile"){
				return getEventsJSON($moduleComponentId);
				exit;
			}
			if($_GET['subaction']=="schedule"){
				return "schedule";
			}
		}
		else{
			return selectViewSubaction();
		}
	}
	public function actionCsg(){
		global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
		$moduleComponentId=$this->moduleComponentId;
		$userId=$this->userId;
		return "hello";
	}
	public function actionEventshead(){
		global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
		$moduleComponentId=$this->moduleComponentId;
		$userId=$this->userId;
		require_once("$sourceFolder/$moduleFolder/events/events_common.php");
		require_once("$sourceFolder/$moduleFolder/events/events_forms.php");
		if(isset($_POST['eventName'])){
			validateEventData($moduleComponentId);
			exit();
		}
		if(isset($_GET['subaction'])){
			if($_GET['subaction']=="viewAll"){
				return getAllEvents($moduleComponentId);
			}
			if($_GET['subaction']=="addEvent"){
				return addNewEvent();
			}
			if($_GET['subaction']=="deleteEvent"){
				return deleteEvent($_POST['eventId'], $moduleComponentId);
				exit();
			}
			if($_GET['subaction']=="editEvent"){
				return "EDITING";
			}
		}
		else{
			return selectEventsHeadSubaction();
		}
	}
	public function actionOchead(){
		global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
		$moduleComponentId=$this->moduleComponentId;
		$userId=$this->userId;
		return "hello";
	}
	public function actionOcteam(){
		global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
		$moduleComponentId=$this->moduleComponentId;
		$userId=$this->userId;
		return "hello";
	}
	public function actionQa(){
			global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
			$moduleComponentId=$this->moduleComponentId;
			$userId=$this->userId;
			require_once("$sourceFolder/$moduleFolder/events/events_common1.php");
			require_once("$sourceFolder/$moduleFolder/events/events_forms.php");
			if(isset($_GET['subaction'])){
				if($_GET['subaction']=="viewEvent"){
					$eventId=trim(escape($_POST['eventId']));
					if(!empty($eventId)){
						return eventParticipants($moduleComponentId,$eventId);
					}
				}
			else if($_GET['subaction'] == "confirmParticipant"){
				$confirmUserid = trim(escape($_POST['userid']));
				$confirmEventId = trim(escape($_POST['eventid']));
				if(!empty($userId)){
					return confirmParticipation($moduleComponentId,$confirmEventId,$confirmUserid);
				}
			}
		}
		else{
			//return smartTableTest($moduleComponentId);
			return displayQA($moduleComponentId);
		}
	}
	public function actionPr(){
		global $urlRequestRoot,$sourceFolder,$templateFolder,$cmsFolder,$moduleFolder;
		$moduleComponentId=$this->moduleComponentId;
		$userId=$this->userId;
		return "hello";
	}

	public static function getFileAccessPermission($pageId,$moduleComponentId,$userId, $fileName)
	{
		return getPermissions($userId, $pageId, "view");
	}

	public static function getUploadableFileProperties(&$fileTypesArray,&$maxFileSizeInBytes)
	{
		$fileTypesArray = array('jpg','jpeg','png','doc','pdf','gif','bmp','css','js','html','xml','ods','odt','oft','pps','ppt','t\
			ex','tiff','txt','chm','mp3','mp2','wave','wav','mpg','ogg','mpeg','wmv','wma','wmf','rm','avi','gzip','gz','rar','bmp','psd','bz2','tar','zip','swf','fla','flv','eps','xcf','xls','exe','7z');
		$maxFileSizeInBytes = 30*1024*1024;
	}




	public function deleteModule($moduleComponentId) {
		return true;
	}
	public function createModule($moduleComponentId) {
    ///No initialization
	}


	public function copyModule($moduleComponentId, $newId) {
		return true;
	}

}

