<?php
class SupabaseClient {
    private $url;
    private $apiKey;
    
    public function __construct($useServiceRole = false) {
        $this->url = SUPABASE_URL;
        // Use secret key for admin operations, publishable key for user operations
        $this->apiKey = $useServiceRole ? SUPABASE_SECRET_KEY : SUPABASE_PUBLISHABLE_KEY;
    }
    
    private function makeRequest($method, $endpoint, $data = null, $useServiceRole = false) {
        $url = $this->url . '/rest/v1/' . $endpoint;
        
        // Modern Supabase API headers
        $headers = [
            'Content-Type: application/json',
            'apikey: ' . ($useServiceRole ? SUPABASE_SECRET_KEY : SUPABASE_PUBLISHABLE_KEY),
            'Authorization: Bearer ' . ($useServiceRole ? SUPABASE_SECRET_KEY : SUPABASE_PUBLISHABLE_KEY),
            'Prefer: return=representation'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }
        
        if ($httpCode >= 200 && $httpCode < 300) {
            $decoded = json_decode($response, true);
            return $decoded;
        } else {
            $errorData = json_decode($response, true);
            $errorMessage = $errorData['message'] ?? $errorData['error'] ?? "API request failed with code: $httpCode";
            throw new Exception("Supabase API Error: " . $errorMessage);
        }
    }
    
    public function select($table, $columns = '*', $filters = [], $limit = null, $offset = 0) {
        $endpoint = $table . '?select=' . $columns;
        
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $endpoint .= '&' . $key . '=eq.' . urlencode($value);
            }
        }
        
        if ($limit) {
            $endpoint .= '&limit=' . $limit;
        }
        
        if ($offset > 0) {
            $endpoint .= '&offset=' . $offset;
        }
        
        return $this->makeRequest('GET', $endpoint);
    }
    
    public function insert($table, $data, $useServiceRole = false) {
        return $this->makeRequest('POST', $table, $data, $useServiceRole);
    }
    
    public function update($table, $data, $filters = [], $useServiceRole = false) {
        $endpoint = $table;
        if (!empty($filters)) {
            $endpoint .= '?';
            $filterParts = [];
            foreach ($filters as $key => $value) {
                $filterParts[] = $key . '=eq.' . urlencode($value);
            }
            $endpoint .= implode('&', $filterParts);
        }
        
        return $this->makeRequest('PATCH', $endpoint, $data, $useServiceRole);
    }
    
    public function delete($table, $filters = [], $useServiceRole = false) {
        $endpoint = $table;
        if (!empty($filters)) {
            $endpoint .= '?';
            $filterParts = [];
            foreach ($filters as $key => $value) {
                $filterParts[] = $key . '=eq.' . urlencode($value);
            }
            $endpoint .= implode('&', $filterParts);
        }
        
        return $this->makeRequest('DELETE', $endpoint, null, $useServiceRole);
    }
    
    public function count($table, $filters = []) {
        $endpoint = $table . '?select=count';
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $endpoint .= '&' . $key . '=eq.' . urlencode($value);
            }
        }
        
        $result = $this->makeRequest('GET', $endpoint);
        return $result[0]['count'] ?? 0;
    }
    
    // Modern Supabase Auth methods
    public function authSignUp($email, $password, $userData = []) {
        $data = [
            'email' => $email,
            'password' => $password
        ];
        
        if (!empty($userData)) {
            $data['user_metadata'] = $userData;
        }
        
        return $this->makeRequest('POST', 'auth/v1/signup', $data);
    }
    
    public function authSignIn($email, $password) {
        $data = [
            'email' => $email,
            'password' => $password
        ];
        
        return $this->makeRequest('POST', 'auth/v1/token?grant_type=password', $data);
    }
    
    public function authSignOut($accessToken) {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . '/auth/v1/logout');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode >= 200 && $httpCode < 300;
    }
    
    public function getUser($accessToken) {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . '/auth/v1/user');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            throw new Exception("Failed to get user: " . $response);
        }
    }
}

// Create global instances for different use cases
$supabase = new SupabaseClient(false); // For user operations (uses anon key)
$supabaseAdmin = new SupabaseClient(true); // For admin operations (uses service role key) 