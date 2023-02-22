<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class ArticlePageController extends PageController
{
    private static $allowed_actions = [
        'CommentForm',
    ];

    public function CommentForm()
    {
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('Name',''),
                EmailField::create('Email',''),
                TextareaField::create('Comment','')
            ),
            FieldList::create(
                FormAction::create('handleComment','Post Comment')
                    ->setUseButtonTag(true)
                    ->addExtraClass('btn btn-default-color btn-lg')
            ),
            RequiredFields::create('Name','Email','Comment')
        )->addExtraClass('form-style');

        foreach($form->Fields() as $field) {
            $field->addExtraClass('form-control')
                ->setAttribute('placeholder', $field->getName().'*');
        }

        $data = $this->getRequest()->getSession()->get("FormData.{$form->getName()}.data");
        return $data ? $form->loadDataFrom($data) : $form;
    }

    public function handleComment($data, $form)
    {
        $session = $this->getRequest()->getSession();
        $session->set("FormData.{$form->getName()}.data", $data);

        $existing = $this->Comments()->filter([
            'Comment' => $data['Comment']
        ]);
        if($existing->exists()) {
            $form->sessionMessage('That comment already exists! Spammer!','bad');

            return $this->redirectBack();
        }

        $comment = ArticleComment::create();
        $comment->Name = $data['Name'];
        $comment->Email = $data['Email'];
        $comment->Comment = $data['Comment'];
        $comment->ArticlePageID = $this->ID;
        $comment->write();

        $session->clear("FormData.{$form->getName()}.data");

        $form->sessionMessage('Thanks for your comment!','good');

        return $this->redirectBack();
    }
}