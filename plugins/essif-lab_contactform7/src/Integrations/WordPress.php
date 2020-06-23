<?php

namespace TNO\ContactForm7\Integrations;

use TNO\ContactForm7\Integrations\Contracts\BaseIntegration;
use TNO\ContactForm7\Utilities\Helpers\CF7Helper;

class WordPress extends BaseIntegration
{
    public function install(CF7Helper $cf7Helper): void
    {
        $this->utility->addEssifLabFormTag();
        $this->utility->loadCustomScripts();

<<<<<<< HEAD
<<<<<<< HEAD
		$this->utility->addActivateHook($cf7Helper, $this->application->getAppDir());
		$this->utility->addDeactivateHook($cf7Helper, $this->application->getAppDir());
	}
=======
        $this->utility->addActivateHook($cf7Helper);
        $this->utility->addDeactivateHook($cf7Helper);
    }
>>>>>>> 44a9692... Applying patch StyleCI
}
=======
        $this->utility->addActivateHook($cf7Helper);
        $this->utility->addDeactivateHook($cf7Helper);
    }
}
>>>>>>> a4f0582... fixed activation hook
