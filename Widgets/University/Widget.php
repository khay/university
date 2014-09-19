<?php

namespace University;

use University\Model\Agent;
use Auth;

class Widget extends \Reborn\Widget\AbstractWidget
{
    protected $agent;

    protected $title;

    protected $properties = array(
            'name' => 'Online Uni Application',
            'author' => 'K',
            'sub' 			=> array(
                'header' 	=> array(
                    'title' => 'Student/Agent Panel',
                    'description' => 'User login and action panel for header.',
                )
            ),
        );

    public function options()
    {
        return array(
            'header' => array(
                'title' => array(
                    'label' 	=> 'Title',
                    'type'		=> 'text',
                    'info'		=> 'Leave it blank if you don\'t want to show your widget title',
                )
            )
        );
    }

    public function __construct()
    {
        $this->agent = Auth::getUser();
        $this->title = $this->get('title', '');
    }

    public function header()
    {
        if (Auth::check()) {
            
            $checkAgent = Agent::where('agentId', "=" , 2)->get();

            return $this->show(array(
                'user' => $this->agent,
                'checkAgent' => $checkAgent,
                'title' => $this->title), 
            'navdisplay');

        } else {            
            return $this->show(array('title' => $this->title), 'navlogin');
        }
    }
}
