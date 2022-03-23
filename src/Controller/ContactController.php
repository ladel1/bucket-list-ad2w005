<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(MailerInterface $mailer,Request $request): Response
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class,$contact);
        $contactForm->handleRequest($request);
        if($contactForm->isSubmitted() && $contactForm->isValid()){
         
            $email = (new Email())
            ->from($contact->getEmail())
            ->to('adel.latibi@gmail.com')
            ->subject($contact->getSubject())
            ->html("<p>Hello {$contact->getEmail()} <br> {$contact->getMessage()} <br> Cordialment. </p>");

            $mailer->send($email);
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
