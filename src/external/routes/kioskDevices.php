<?php

use ChurchCRM\ConfigQuery;
use ChurchCRM\Family;
use ChurchCRM\ListOptionQuery;
use ChurchCRM\Person;
use Slim\Views\PhpRenderer;
use ChurchCRM\GroupQuery;
use ChurchCRM\Person2group2roleP2g2rQuery;
use ChurchCRM\PersonQuery;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Propel\Runtime\ActiveQuery\Criteria;


$app->group('/kioskdevices', function () {

  $this->get('/{guid}', function ($request, $response, $args) {

      $renderer = new PhpRenderer("templates/kioskDevices/");
      $pageObjects = array("sRootPath" => $_SESSION['sRootPath'], "thisDeviceGuid" => $args['guid']);
      return $renderer->render($response, "sunday-school-class-view.php", $pageObjects);

    });
    
    $this->get('/{guid}/activeClassMembers', function ($request, $response, $args) {
      $ssClass = PersonQuery::create()
              ->joinWithPerson2group2roleP2g2r()
              ->usePerson2group2roleP2g2rQuery()
                ->filterByGroupId(2)
                ->joinGroup()
                ->innerJoin("ListOption")
                ->addJoinCondition("ListOption", "Group.RoleListId = ListOption.Id")
              ->withColumn(ChurchCRM\Map\ListOptionTableMap::COL_LST_OPTIONNAME,"RoleName")
              ->endUse()
              ->select(array("Id","FirstName","LastName"))
              ->find();
      return $ssClass->toJSON();
    });
    
    
    $this->get('/{guid}/activeEvent', function ($request, $response, $args) {
      $Event = \ChurchCRM\EventQuery::create()
              ->filterByStart('now', Criteria::LESS_EQUAL)
              ->filterByEnd('now',Criteria::GREATER_EQUAL)
              ->find();
      return $Event->toJSON();
    });
    
    $this->get('/{guid}/activeEvent/checkin', function ($request, $response, $args) {
      
    });
    
    $this->get('/{guid}/activeEvent/checkout', function ($request, $response, $args) {
      
    });
    
    
    
    $this->get('/{guid}/activeClassMember/{PersonId}/photo', function (ServerRequestInterface  $request, ResponseInterface  $response, $args) {
     $person = PersonQuery::create()->findPk($args['PersonId']);
        if ($person->isPhotoLocal()) {
            return $response->write($person->getPhotoBytes())->withHeader('Content-type', $person->getPhotoContentType());
        } else if ($person->isPhotoRemote()) {
            return $response->withRedirect($person->getPhotoURI());
        } else {
            return $response->withStatus(404);
        }
    });
  
});


