<?php

namespace Jeetendra\SymfonyLogViewerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ViewerController extends BaseController
{
    /**
     * @Route("/view", name="symofny_log_view")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return $this->getLogs($this->getLimit($request), $this->getOffset($request));
    }

    protected function getLimit(Request $request)
    {
        return min(100, $request->query->get('length', 10));
    }

    protected function getOffset(Request $request)
    {
        return max($request->query->get('start', 1), 1);
    }
}
