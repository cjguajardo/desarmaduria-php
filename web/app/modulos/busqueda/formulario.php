<?php

/**
 * Retrieves the value of a query parameter from the $_GET superglobal array.
 *
 * @param string $name The name of the query parameter.
 * @return string The value of the query parameter, or an empty string if it is not set.
 */
function getParam(string $name): string
{
  return isset($_GET[$name]) ? $_GET[$name] : "";
}

/**
 * Retrieves the filter parameters from the request.
 *
 * @return array The filter parameters.
 */
function getFilterParams(): array
{
  $params = [];
  $params["marca"] = getParam("marca");
  $params["modelo"] = getParam("modelo");
  $params["agno"] = getParam("agno");
  $params["combustible"] = getParam("combustible");

  $params = array_filter($params, function ($v) {
    return $v != '';
  });

  return $params;
}

/**
 * Returns the "selected" attribute if the given value matches the value of the parameter with the specified name.
 *
 * @param string $name The name of the parameter.
 * @param mixed $value The value to compare against the parameter value.
 * @return string The "selected" attribute if the value matches, otherwise an empty string.
 */
function getSelected(string $name, $value): string
{
  $param = getParam($name);
  if ($param == '') return '';
  return $param == $value ? "selected" : "";
}

/**
 * Renders a select element with options based on the given data.
 *
 * @param string $name The name attribute of the select element.
 * @param array $data An array containing the data for the options.
 * @return string The HTML representation of the select element.
 */
function renderSelect(string $name, array $data): string
{
  $html = "<select class='form-select' id='$name' name='$name'>";
  $html .= "<option value=''>" . ucfirst($name) . "</option>";
  foreach ($data as $v) {
    $html .= "<option value='" . $v[$name] . "' " . getSelected($name, $v[$name]) . ">" . $v[$name] . "</option>";
  }
  $html .= "</select>";
  return $html;
}

/**
 * Renders the search form for the given section.
 *
 * @param string $section The section for which the form is rendered.
 * @return string The HTML representation of the search form.
 */
function renderFormulario($section): string
{
  global $conn;

  $marcas = [];
  $query = "SELECT DISTINCT v.MARCA AS marca FROM vehiculo v ORDER BY v.MARCA ASC;";
  if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
      $marcas[] = $row;
    }
  }

  $modelos = [];
  $query = "SELECT DISTINCT v.MODELO AS modelo FROM vehiculo v ORDER BY v.MODELO ASC;";
  if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
      $modelos[] = $row;
    }
  }

  $agnos = [];
  $query = "SELECT DISTINCT v.AGNO AS agno FROM vehiculo v ORDER BY v.AGNO ASC;";
  if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
      $agnos[] = $row;
    }
  }

  $combustibles = [];
  $query = "SELECT DISTINCT v.COMBUSTIBLE AS combustible FROM vehiculo v ORDER BY v.COMBUSTIBLE ASC;";
  if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
      $combustibles[] = $row;
    }
  }

  $html = '';
  $html .= '<form action="" method="get">';
  $html .= '  <input type="hidden" name="section" value="' . $section . '" />';
  $html .= '  <table class="table table-responsive">';
  $html .= '    <thead>';
  $html .= '      <tr>';
  $html .= '        <th width="25%">';
  $html .= '          <div class="form-group">';
  $html .= '            <label for="marca">Marca</label>';
  $html .=            renderSelect('marca', $marcas);;
  $html .= '          </div>';
  $html .= '        </th>';
  $html .= '        <th width="25%">';
  $html .= '          <div class="form-group">';
  $html .= '            <label for="modelo">Modelo</label>';
  $html .=            renderSelect('modelo', $modelos);
  $html .= '          </div>';
  $html .= '        </th>';
  $html .= '        <th>';
  $html .= '          <div class="form-group">';
  $html .= '            <label for="agno">A&ntilde;o</label>';
  $html .=            renderSelect('agno', $agnos);
  $html .= '          </div>';
  $html .= '        </th>';
  $html .= '        <th width="15%">';
  $html .= '          <div class="form-group">';
  $html .= '            <label for="combustible">Combustible</label>';
  $html .=            renderSelect('combustible', $combustibles);
  $html .= '          </div>';
  $html .= '        </th>';
  $html .= '        <th>';
  $html .= '          <button type="submit" class="btn btn-primary w-100">Buscar</button>';
  $html .= '        </th>';
  $html .= '      </tr>';
  $html .= '    </thead>';
  $html .= '  </table>';
  $html .= '</form>';

  return $html;
}


function renderFormulario2(
  string $section,
  bool $incluyeMarca,
  bool $incluyeModelo,
  bool $incluyeAgno,
  bool $incluyeCombustible
): string {
  global $conn;

  $marcas = [];
  if ($incluyeMarca) {
    $query = "SELECT DISTINCT v.MARCA AS marca FROM accesorio v ORDER BY v.MARCA ASC;";
    if ($result = $conn->query($query)) {
      while ($row = $result->fetch_assoc()) {
        $marcas[] = $row;
      }
    }
  }

  $modelos = [];
  if ($incluyeModelo) {
    $query = "SELECT DISTINCT v.MODELO AS modelo FROM vehiculo v ORDER BY v.MODELO ASC;";
    if ($result = $conn->query($query)) {
      while ($row = $result->fetch_assoc()) {
        $modelos[] = $row;
      }
    }
  }

  $agnos = [];
  if ($incluyeAgno) {
    $query = "SELECT DISTINCT v.AGNO AS agno FROM vehiculo v ORDER BY v.AGNO ASC;";
    if ($result = $conn->query($query)) {
      while ($row = $result->fetch_assoc()) {
        $agnos[] = $row;
      }
    }
  }

  $combustibles = [];
  if ($incluyeCombustible) {
    $query = "SELECT DISTINCT v.COMBUSTIBLE AS combustible FROM vehiculo v ORDER BY v.COMBUSTIBLE ASC;";
    if ($result = $conn->query($query)) {
      while ($row = $result->fetch_assoc()) {
        $combustibles[] = $row;
      }
    }
  }

  $html = '';
  $html .= '<form action="" method="get">';
  $html .= '  <input type="hidden" name="section" value="' . $section . '" />';
  $html .= '  <table class="table table-responsive">';
  $html .= '    <thead>';
  $html .= '      <tr>';
  if ($incluyeMarca) {
    $html .= '        <th width="25%">';
    $html .= '          <div class="form-group">';
    $html .= '            <label for="marca">Marca</label>';
    $html .=            renderSelect('marca', $marcas);;
    $html .= '          </div>';
    $html .= '        </th>';
  }
  if ($incluyeModelo) {
    $html .= '        <th width="25%">';
    $html .= '          <div class="form-group">';
    $html .= '            <label for="modelo">Modelo</label>';
    $html .=            renderSelect('modelo', $modelos);
    $html .= '          </div>';
    $html .= '        </th>';
  }
  if ($incluyeAgno) {
    $html .= '        <th>';
    $html .= '          <div class="form-group">';
    $html .= '            <label for="agno">A&ntilde;o</label>';
    $html .=            renderSelect('agno', $agnos);
    $html .= '          </div>';
    $html .= '        </th>';
  }
  if ($incluyeCombustible) {
    $html .= '        <th width="25%">';
    $html .= '          <div class="form-group">';
    $html .= '            <label for="combustible">Combustible</label>';
    $html .=            renderSelect('combustible', $combustibles);
    $html .= '          </div>';
    $html .= '        </th>';
  }
  $html .= '        <th width="15%">';
  $html .= '          <button type="submit" class="btn btn-primary w-100">Buscar</button>';
  $html .= '        </th>';
  $html .= '      </tr>';
  $html .= '    </thead>';
  $html .= '  </table>';
  $html .= '</form>';

  return $html;
}
