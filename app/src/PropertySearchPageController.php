<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Control\HTTP;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;

class PropertySearchPageController extends PageController
{
    public function index(HTTPRequest $request)
    {
        $properties = Property::get();
        $activeFilters = ArrayList::create();

        if ($search = $request->getVar('Keywords')) {
            $activeFilters->push(ArrayData::create([
                'Label' => "Keywords: '$search'",
                'RemoveLink' => HTTP::setGetVar('Keywords', null, null, '&'),
            ]));

            $properties = $properties->filter([
                'Title:PartialMatch' => $search
            ]);
        }

        if ($arrival = $request->getVar('ArrivalDate')) {
            $arrivalStamp = strtotime($arrival);                        
            $nightAdder = '+'.$request->getVar('Nights').' days';
            $startDate = date('Y-m-d', $arrivalStamp);
            $endDate = date('Y-m-d', strtotime($nightAdder, $arrivalStamp));
        
            $properties = $properties->filter([
                'AvailableStart:GreaterThanOrEqual' => $startDate,
                'AvailableEnd:LessThanOrEqual' => $endDate
            ]);
        
        }

        $filters = [
            ['Bedrooms', 'Bedrooms', 'GreaterThanOrEqual', '%s bedrooms'],
            ['Bathrooms', 'Bathrooms', 'GreaterThanOrEqual', '%s bathrooms'],
            ['MinPrice', 'PricePerNight', 'GreaterThanOrEqual', 'Min. $%s'],
            ['MaxPrice', 'PricePerNight', 'LessThanOrEqual', 'Max. $%s'],
        ];
    
        foreach($filters as $filterKeys) {
            list($getVar, $field, $filter, $labelTemplate) = $filterKeys;
            if ($value = $request->getVar($getVar)) {
                $activeFilters->push(ArrayData::create([
                    'Label' => sprintf($labelTemplate, $value),
                    'RemoveLink' => HTTP::setGetVar($getVar, null, null, '&'),
                ]));
    
                $properties = $properties->filter([
                    "{$field}:{$filter}" => $value
                ]);
            }
        }

        $paginatedProperties = PaginatedList::create(
            $properties,
            $request
        )->setPageLength(5);

        if($request->isAjax()) {
            return $this->customise([
                'Results' => $paginatedProperties
            ])->renderWith('SilverStripe/Lessons/Includes/PropertySearchResults');
        }

        return [
            'Results' => $paginatedProperties,
            'ActiveFilters' => $activeFilters,
        ];
    }

    public function PropertySearchForm()
    {
        $nights = [];
        foreach(range(1,14) as $i) {
            $nights[$i] = "$i night" . (($i > 1) ? 's' : '');
        }
        $prices = [];
        foreach(range(100, 1000, 50) as $i) {
            $prices[$i] = '$'.$i;
        }

        $form = Form::create(
            $this,
            'PropertySearchForm',
            FieldList::create(
                TextField::create('Keywords')
                    ->setAttribute('placeholder', 'City, State, Country, etc...')
                    ->addExtraClass('form-control'),
                TextField::create('ArrivalDate','Arrive on...')             
                    ->setAttribute('data-datepicker', true)
                    ->setAttribute('data-date-format', 'DD-MM-YYYY')
                    ->addExtraClass('form-control'),
                DropdownField::create('Nights','Stay for...')                   
                    ->setSource($nights)
                    ->addExtraClass('form-control'),
                DropdownField::create('Bedrooms')                   
                    ->setSource(ArrayLib::valuekey(range(1,5)))
                    ->addExtraClass('form-control'),
                DropdownField::create('Bathrooms')                  
                    ->setSource(ArrayLib::valuekey(range(1,5)))
                    ->addExtraClass('form-control'),
                DropdownField::create('MinPrice','Min. price')
                    ->setEmptyString('-- any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control'),
                DropdownField::create('MaxPrice','Max. price')
                    ->setEmptyString('-- any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control')             
            ),
            FieldList::create(
                FormAction::create('doPropertySearch','Search')
                    ->addExtraClass('btn-lg btn-fullcolor')
            )
        );

        $form->setFormMethod('GET')->setFormAction($this->Link())->disableSecurityToken()->loadDataFrom($this->request->getVars());

        return $form;
    }
}