<?php

namespace SaviorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function adminAction() {
        return $this->render('@Saviors/Admin/admin.html.twig');
    }

    public function notfoundAction() {
        return $this->render('@Saviors/Admin/404.html.twig');
    }

    public function alertsAction() {
        return $this->render('@Saviors/Admin/alerts.html.twig');
    }

    public function blankAction() {
        return $this->render('@Saviors/Admin/blank.html.twig');
    }

    public function buttonsAction() {
        return $this->render('@Saviors/Admin/buttons.html.twig');
    }

    public function chartsAction() {
        return $this->render('@Saviors/Admin/charts.html.twig');
    }

    public function copycontentAction() {
        return $this->render('@Saviors/Admin/copycontent.html.twig');
    }

    public function datatablesAction() {
        return $this->render('@Saviors/Admin/datatables.html.twig');
    }

    public function dropdownsAction() {
        return $this->render('@Saviors/Admin/dropdowns.html.twig');
    }

    public function formsAction() {
        return $this->render('@Saviors/Admin/forms.html.twig');
    }

    public function loginadminAction() {
        return $this->render('@Saviors/Admin/login.html.twig');
    }

    public function modalsAction() {
        return $this->render('@Saviors/Admin/modals.html.twig');
    }

    public function popoversAction() {
        return $this->render('@Saviors/Admin/popovers.html.twig');
    }

    public function progressbarAction() {
        return $this->render('@Saviors/Admin/progress-bar.html.twig');
    }

    public function registeradminAction() {
        return $this->render('@Saviors/Admin/register.html.twig');
    }

    public function simpletablesAction() {
        return $this->render('@Saviors/Admin/simple-tables.html.twig');
    }

    public function uicolorsAction() {
        return $this->render('@Saviors/Admin/ui-colors.html.twig');
    }
}
