<?php

namespace University;

use University\Model\Agent;
use Auth;

class Widget extends \Reborn\Widget\AbstractWidget
{
    protected $_user;

    protected $_title;

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
        $this->_user = Auth::getUser();

        $agent = Auth::getGroupProvider()->findBy('name', 'Agents');

        $this->_title = $this->get('title', '');
    }

    public function header()
    {
        if (Auth::check()) {
            
            $checkAgent = Agent::where('agentId', "=" , $this->_user->id)->count();

            return $this->show(array(
                'user' => $this->_user,
                'checkAgent' => $checkAgent,
                'title' => $this->_title), 
            'navdisplay');

        } else {            
            return $this->show(array('title' => $this->_title), 'navlogin');
        }
    }
}
