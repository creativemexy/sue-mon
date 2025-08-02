<?php
class SupabaseClient {
    private $url;
    private $anonKey;
    private $serviceRoleKey;
    
    public function __construct() {
        $this->url = SUPABASE_URL;
        $this->anonKey = SUPABASE_ANON_KEY;
        $this->serviceRoleKey = SUPABASE_SERVICE_ROLE_KEY;
    }
    
    private function makeRequest($method, $endpoint, $data = null, $useServiceRole = false) {
        $url = $this->url . '/rest/v1/' . $endpoint;
        
        $headers = [
            'Content-Type: application/json',
            'apikey: ' . ($useServiceRole ? $this->serviceRoleKey : $this->anonKey),
            'Authorization: Bearer ' . ($useServiceRole ? $this->serviceRoleKey : $this->anonKey)
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            throw new Exception("API request failed: " . $response);
        }
    }
    
    public function select($table, $columns = '*', $filters = []) {
        $endpoint = $table . '?select=' . $columns;
        
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $endpoint .= '&' . $key . '=eq.' . urlencode($value);
            }
        }
        
        return $this->makeRequest('GET', $endpoint);
    }
    
    public function insert($table, $data) {
        return $this->makeRequest('POST', $table, $data, true);
    }
    
    public function update($table, $data, $filters = []) {
        $endpoint = $table;
        if (!empty($filters)) {
            $endpoint .= '?';
            $filterParts = [];
            foreach ($filters as $key => $value) {
                $filterParts[] = $key . '=eq.' . urlencode($value);
            }
            $endpoint .= implode('&', $filterParts);
        }
        
        return $this->makeRequest('PATCH', $endpoint, $data, true);
    }
    
    public function delete($table, $filters = []) {
        $endpoint = $table;
        if (!empty($filters)) {
            $endpoint .= '?';
            $filterParts = [];
            foreach ($filters as $key => $value) {
                $filterParts[] = $key . '=eq.' . urlencode($value);
            }
            $endpoint .= implode('&', $filterParts);
        }
        
        return $this->makeRequest('DELETE', $endpoint, null, true);
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
}

// Create global instance
$supabase = new SupabaseClient(); 