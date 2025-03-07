<?php

class ViewAccueil
{
  private ?string $message = '';
  private ?string $listeJoueurs = '';

  public function getMessage(): ?string
  {
    return $this->message;
  }

  public function setMessage(?string $newMessage): self
  {
    $this->message = $newMessage;
    return $this;
  }

  public function getListeJoueurs(): ?string
  {
    return $this->listeJoueurs;
  }

  public function setListeJoueurs(?string $newListeJoueurs): self
  {
    $this->listeJoueurs = $newListeJoueurs;
    return $this;
  }

  //METHOD
  public function displayView(): string
  {
    return ("
                <main>
                  <section>
                    <h2>Enregistrer nouveau joueur</h2>
                    <form action='' method='post'>
                      <label for='pseudo'>Pseudo</label><br />
                      <input type='text' name='pseudo' id='pseudo' required><br /><br />

                      <label for='email'>E-mail</label><br />
                      <input type='text' name='email' id='email' required /><br /><br />

                      <label for='password'>Mot de Passe</label><br />
                      <input type='password' name='password' id='password' required /><br /><br />

                      <label for='score'>Score</label><br />
                      <input type='number' name='score' id='score' required /><br /><br />

                      <input type='submit' name='submit' value='Enregistrer' required /><br />

                      <p>" . $this->getMessage() . "</p>

                    </form>
                  </section>
                  <section>
                    <h1>Liste de joueurs</h1>
                    <ul>
                    " . $this->getListeJoueurs() . "
                    </ul>
                    </section>
                </main>
        ");
  }
}
