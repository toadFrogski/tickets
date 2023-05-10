<?php

namespace Src\Controllers;

use Core\HttpFoundation\Request;
use Core\Template\Template;

use Src\Repository\SessionRepository;
use Src\Repository\TicketRepository;

class TicketController
{
    public function indexAction(Request $request) {
        $id = $request->getParameters()['session'];
        return Template::view('ticket/index.html',  ['session' => SessionRepository::getSessionById($id)]);
    }

    public function buyAction(Request $request) {
        $data = $request->getParameters();
        if ($session = $this->validate($data)) {
            $session['session_schema'][$data['row']][$data['place']] = false;
            SessionRepository::updateSessionSchema($session['session_id'], json_encode($session['session_schema']));
            TicketRepository::setTicket($data['row'], $data['place'], $session['session_id']);
        }
    }

    private function validate(array $data) {

        foreach (['session_id', 'row', 'place'] as $requirement) {
            if (!isset($data[$requirement])) {
                return false;
            }
        }

        $session = SessionRepository::getSessionById($data['session_id']);

        if (!$session['session_schema'][$data['row']][$data['place']]) {
            return false;
        }

        if ($session['session_time'] < date('Y-m-d H:i:s')) {
            return false;
        }

        return $session;
    }
}