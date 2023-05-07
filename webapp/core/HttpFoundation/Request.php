<?

namespace Core\HttpFoundation;

class Request
{
    private string $path = '';
    private array $parameters = [];

    public function __construct(string $uri) {
        if (str_contains($uri, '?')) {
            [$this->path, $queryset] = explode('?', $uri);
            array_map(function($q_parameter) { 
                    [$key, $value] = explode('=', $q_parameter);
                    $this->parameters[$key] = $value;
                },
                explode('&', $queryset));
        } else {
            $this->path = $uri;
        }
        if (!empty($_POST)) {
            array_walk($_POST, function($value, $key) { $this->parameters[$key] = $value; });
        }
    }

    public function getPath() {
        return $this->path;
    }

    public function getParameters() {
        return $this->parameters;
    }
}