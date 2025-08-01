"use client"

import { useState, useEffect } from "react";
import { supabase } from "@/integrations/supabase/client";
import { useAuth } from "@/contexts/AuthContext";

export const SupabaseDebug = () => {
  const { user } = useAuth();
  const [debugInfo, setDebugInfo] = useState<any>({});
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const runDebugTests = async () => {
      const info: any = {
        supabaseUrl: process.env.NEXT_PUBLIC_SUPABASE_URL,
        supabaseKey: process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY ? 'Set' : 'Not set',
        user: user ? { id: user.id, email: user.email } : 'No user',
        timestamp: new Date().toISOString()
      };

      try {
        // Test 1: Basic connection
        console.log('Testing Supabase connection...');
        const { data: testData, error: testError } = await supabase
          .from('user_roles')
          .select('count')
          .limit(1);

        info.connectionTest = {
          success: !testError,
          error: testError ? {
            code: testError.code,
            message: testError.message,
            details: testError.details
          } : null
        };

        // Test 2: Check if table exists
        if (testError?.code === '42P01') {
          info.tableExists = false;
          info.tableError = 'Table does not exist';
        } else if (testError?.code === 'PGRST116') {
          info.tableExists = true;
          info.tableError = 'RLS policy violation';
        } else if (!testError) {
          info.tableExists = true;
          info.tableError = null;
        } else {
          info.tableExists = 'Unknown';
          info.tableError = testError.message;
        }

        // Test 3: Try to create a test record (will fail due to RLS, but shows table exists)
        if (user) {
          const { error: insertError } = await supabase
            .from('user_roles')
            .insert({ user_id: user.id, role: 'test' });

          info.insertTest = {
            success: !insertError,
            error: insertError ? {
              code: insertError.code,
              message: insertError.message
            } : null
          };
        }

      } catch (error: any) {
        info.exception = {
          name: error.name,
          message: error.message,
          stack: error.stack
        };
      }

      setDebugInfo(info);
      setLoading(false);
    };

    runDebugTests();
  }, [user]);

  if (loading) {
    return <div className="p-4 bg-yellow-100 border border-yellow-400 rounded">
      <h3 className="font-bold text-yellow-800">Supabase Debug - Loading...</h3>
    </div>;
  }

  return (
    <div className="p-4 bg-blue-100 border border-blue-400 rounded mb-4">
      <h3 className="font-bold text-blue-800 mb-2">Supabase Debug Info</h3>
      <pre className="text-xs overflow-auto max-h-96">
        {JSON.stringify(debugInfo, null, 2)}
      </pre>
      
      {debugInfo.tableExists === false && (
        <div className="mt-4 p-3 bg-red-100 border border-red-400 rounded">
          <h4 className="font-bold text-red-800">⚠️ Table Missing</h4>
          <p className="text-red-700 text-sm">
            The user_roles table does not exist. You need to run the SQL setup in your Supabase dashboard.
          </p>
          <div className="mt-2">
            <h5 className="font-semibold text-red-800">Steps to fix:</h5>
            <ol className="text-red-700 text-sm list-decimal list-inside">
              <li>Go to your Supabase Dashboard</li>
              <li>Navigate to SQL Editor</li>
              <li>Copy the content from user_roles_setup.sql</li>
              <li>Paste and run the SQL commands</li>
              <li>Refresh this page</li>
            </ol>
          </div>
        </div>
      )}
    </div>
  );
}; 