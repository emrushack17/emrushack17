<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos')) {
            $todos = [
                'achat' => 'achat cle usb',
                'cours' => 'finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', 'la liste vient detre ini');
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/add/{name?Emmanuel}/{content?g9tech}', name: 'app_add_todo')]
    public function addTodo(Request $request, $name, $content)
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])){
                $this->addFlash('error', 'le todo d\'id ' . $name . ' existe deja ');
            } else {
                $todos[$name] = $content;
                $this->addFlash('success', 'le todo d\'id '. $name . 'a ete ajoute avec success');
                $session->set('todos', $todos);
            }
        } else{
            $this->addFlash('error', 'la liste nest pas encore ini');
        }
        return $this->redirect('/todo');
    }

    #[Route('/update/{name}/{content}', name: 'app_update_todo')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (!isset($todos[$name])){
                $this->addFlash('error', 'le todo d\'id ' . $name . ' nexiste pas ');
            } else {
                $todos[$name] = $content;
                $this->addFlash('success', 'le todo d\'id '. $name . 'a ete modifier avec success');
                $session->set('todos', $todos);
            }
        } else{
            $this->addFlash('error', 'la liste nest pas encore ini');
        }
        return $this->redirect('/todo');
    }
    
    #[Route('/delete/{name}', name: 'app_delete_todo')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (!isset($todos[$name])){
                $this->addFlash('error', 'le todo d\'id ' . $name . ' existe deja ');
            } else {
                unset($todos[$name]);
                $this->addFlash('success', 'le todo d\'id '. $name . 'a ete supprimer avec success');
                $session->set('todos', $todos);
            }
        } else{
            $this->addFlash('error', 'la liste nest pas encore ini');
        }
        return $this->redirect('/todo');
    }

    #[Route('/reset', name: 'app_reset_todo')]
    public function resetTodo(Request $request) : RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirect('/todo');
    }
}
