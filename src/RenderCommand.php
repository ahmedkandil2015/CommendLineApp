<?php


namespace Acme;



use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class RenderCommand extends Command
{

    public function configure(){
        $this->setName("render")
            ->setDescription('Render Some Tabual Data');
    }
    public function execute(InputInterface $input,OutputInterface $output)
    {
        $table= new Table($output);
        $table->setHeaders(['Name','Age'])
              ->setRows([
                ['ahmed',30],
                ['mohammed',20]
    ])
        ->render();
    }
}