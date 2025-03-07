<?php

class ViewHeader
{
    public function displayView(): string
    {
        return ("
      <!DOCTYPE html>
      <html lang='en'>

      <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Ex005</title>
      </head>

      <body>
        <header>
          <nav>
            <ul>
            <li>Header 1</li>
            <li>Header 2</li>
            <li>Header 3</li>
            </ul>
          </nav>
        </header>
    ");
    }
}
