/**
 * ChatGPTClient is a PHP class that can be used as a REST API client for ChatGPT.
 *
 * @author Mokter Hossain
 * @author mo@gglink.uk
 */
class ChatGPTClient
{
    /**
     * API Key for authentication.
     *
     * @var string
     */
    private $apiKey;

    /**
     * API endpoint URL.
     *
     * @var string
     */
    private $apiUrl = "https://api.openai.com/v1/engines/chatbot/run";

    /**
     * Class constructor.
     *
     * @param string $apiKey API Key for authentication
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Send a request to the ChatGPT API.
     *
     * @param string $prompt The prompt for the conversation
     * @param int $maxTokens The maximum number of tokens to generate in the response (optional)
     * @param float $temperature The sampling temperature to use (optional)
     *
     * @return array The response from the API as an associative array
     */
    public function sendRequest($prompt, $maxTokens = 100, $temperature = 0.5)
    {
        $ch = curl_init();

        $requestData = array(
            "prompt" => $prompt,
            "max_tokens" => $maxTokens,
            "temperature" => $temperature
        );

        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->apiKey
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}

// exmaple use of the class 
$client = new ChatGPTClient("<API_KEY>");
$response = $client->sendRequest("What is the meaning of life?");
print_r($response);

