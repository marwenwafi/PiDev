<?php


namespace FiThnitekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use nexmo\Client;
use nexmo\Client\Credentials\Basic;
use Nexmo\Client\Exception\Exception;
use Nexmo\Client\Exception\Request;
use Nexmo\Client\Exception\Server;


/**
 * @ORM\Entity (repositoryClass="FiThnitekBundle\Repository\ReponseRepository")
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseRec", type="text")
     */
    private $reponseRec;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumn(name="id_rec",referencedColumnName="id")
     */
    private $id_rec;

    /**
     * @return mixed
     */
    public function getIdRec()
    {
        return $this->id_rec;
    }

    /**
     * @param mixed $id_rec
     */
    public function setIdRec($id_rec)
    {
        $this->id_rec = $id_rec;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getReponseRec()
    {
        return $this->reponseRec;
    }

    /**
     * @param string $reponseRec
     */
    public function setReponseRec($reponseRec)
    {
        $this->reponseRec = $reponseRec;
    }

    public function sendmessage()
    {
        $adapter_client = new \Http\Adapter\Guzzle6\Client(new \GuzzleHttp\Client(['timeout' => 5]));
        $client = new \Nexmo\Client(
            new \Nexmo\Client\Credentials\Basic('5762260d', 'DrwU2x8JUxbkVKPh'),
            [
                'base_api_url' => 'https://rest.nexmo.com/sms/json'
            ], $adapter_client
        );

        try {
            $client->message()->send([
                'to' => '21629288025',
                'from' => 'FiThnitek',
                'text' => 'tessd'
            ]);
        } catch (Request $e) {
        } catch (Server $e) {
        } catch (Exception $e) {
        }

    }
}