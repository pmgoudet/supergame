<?php

include "../utils/utils.php";
include "../model/model_joueurs.php";
include "../view/view_accueil.php";
include "../view/header.php";
include "../view/footer.php";


class ControllerHome
{
  private ?ViewAccueil $viewAccueil;
  private ?ModelPlayer $modelPlayer;
  private ?ViewHeader $viewHeader;
  private ?ViewFooter $viewFooter;


  public function getViewHeader(): ?ViewHeader
  {
    return $this->viewHeader;
  }

  public function setViewHeader(?ViewHeader $viewHeader): self
  {
    $this->viewHeader = $viewHeader;
    return $this;
  }

  public function getViewFooter(): ?ViewFooter
  {
    return $this->viewFooter;
  }

  public function setViewFooter(?ViewFooter $viewFooter): self
  {
    $this->viewFooter = $viewFooter;
    return $this;
  }

  public function __construct(?ViewAccueil $newViewAccueil, ?ModelPlayer $newModelPlayer)
  {
    $this->viewAccueil = $newViewAccueil;
    $this->modelPlayer = $newModelPlayer;
  }

  public function getViewAccueil(): ?ViewAccueil
  {
    return $this->viewAccueil;
  }

  public function setViewAccueil(?ViewAccueil $viewAccueil): self
  {
    $this->viewAccueil = $viewAccueil;
    return $this;
  }

  public function getModelPlayer(): ?ModelPlayer
  {
    return $this->modelPlayer;
  }

  public function setModelPlayer(?ModelPlayer $modelPlayer): self
  {
    $this->modelPlayer = $modelPlayer;
    return $this;
  }



  //METHOD

  public function enregistrer(): string
  {
    //btn submit
    if (isset($_POST['submit'])) {
      //variables not vides ou nulls
      if (
        isset($_POST['pseudo']) && !empty($_POST['pseudo'])
        && isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['score']) && !empty($_POST['score'])
        && isset($_POST['password']) && !empty($_POST['password'])
      ) {
        //validation adresse mail
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $pseudo = sanitize($_POST['pseudo']);
          $email = sanitize($_POST['email']);
          $score = sanitize($_POST['score']);
          $password = sanitize($_POST['password']);
          $password = password_hash($password, PASSWORD_BCRYPT);

          //verification du mail
          try {
            $data = $this->getModelPlayer()->setEmail($email)->getPlayerByMail();


            if (empty($data)) {
              $this->getModelPlayer()->setPseudo($pseudo)->setEmail($email)->setPassword($password)->setScore($score);

              $this->getViewAccueil()->setMessage($this->getModelPlayer()->addPlayer());

              return "$pseudo a été enregistré en BDD.";
            } else {
              return "Cet adresse mail existe déjà sur un autre compte.";
            }
          } catch (EXCEPTION $e) {
            return $e->getMessage();
          }
        } else {
          return "Le mail n'est pas au bon format";
        }
      } else {
        return "Veuillez remplir les champs obligatoires.";
      }
    }
    return '';
  }

  public function listeJoueurs(): string
  {
    $listeJoueurs = '';
    $data = $this->getModelPlayer()->getPlayers();

    foreach ($data as $joueur) {
      $listeJoueurs = $listeJoueurs . "
      <li>
        <h4>Joueur: {$joueur['pseudo']}</h4>
        <p>E-mail: {$joueur['email']}<p>
        <p>Score: {$joueur['score']}<p>
        <hr>
      </li>";
    }
    return $listeJoueurs;
  }

  public function render(): void
  {
    echo $this->setViewHeader(new ViewHeader)->getViewHeader()->displayView();

    echo $this->getViewAccueil()->setMessage($this->enregistrer())->setListeJoueurs($this->listeJoueurs())->displayView();

    echo $this->setViewFooter(new ViewFooter)->getViewFooter()->displayView();
  }
}

$home = new ControllerHome(new ViewAccueil, new ModelPlayer);
$home->render();
