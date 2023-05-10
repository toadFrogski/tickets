<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Routing\Router;
use Core\Template\Template;

use Src\Repository\SessionRepository;
use Src\Repository\TicketRepository;

class TicketController
{
    public function indexAction(Request $request)
    {
        $id = $request->getParameters()['session'];
        return Template::view('ticket/index.html', ['session' => SessionRepository::getSessionById($id)]);
    }

    public function buyAction(Request $request)
    {
        $data = $request->getParameters();
        if ($data = $this->validate($data)) {
            foreach($data['places'] as $place) {
                $data['session']['session_schema'][$place[0]][$place[1]] = false;
                SessionRepository::updateSessionSchema($data['session']['session_id'], json_encode($data['session']['session_schema']));
                TicketRepository::setTicket($place[0], $place[1], $data['session']['session_id']);
            }
        }
        Router::getInstance()->redirect('home');
    }

    private function validate(array $data)
    {

        foreach (['session_id', 'place'] as $requirement) {
            if (!isset($data[$requirement])) {
                return false;
            }
        }
        $places = [];
        $session = SessionRepository::getSessionById($data['session_id']);

        foreach ($data['place'] as $place) {
            $place = explode(';', $place);
            $places[] = $place;
            if (!$session['session_schema'][$place[0]][$place[1]]) {
                return false;
            }
        }


        if ($session['session_time'] < date('Y-m-d H:i:s')) {
            return false;
        }
        return ['session' => $session, 'places' => $places];
    }
}