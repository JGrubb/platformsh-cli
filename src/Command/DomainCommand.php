<?php

namespace CommerceGuys\Platform\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DomainCommand extends PlatformCommand
{
    protected $project;

    protected function validateInput(InputInterface $input, OutputInterface $output)
    {
        // Allow the project to be specified explicitly via --project.
        $projectId = $input->hasOption('project') ? $input->getOption('project') : null;
        if (!empty($projectId)) {
            $project = $this->getProject($projectId);
            if (!$project) {
                $output->writeln("<error>Specified project not found.</error>");
                return;
            }
            $this->project = $project;
        } else {
            // Autodetect the project if the user is in a project directory.
            $this->project = $this->getCurrentProject();
            if (!$this->project) {
                $output->writeln("<error>Could not determine the current project.</error>");
                $output->writeln("<error>Specify it manually using --project or go to a project directory.</error>");
                return;
            }
        }

        return true;
    }
}
