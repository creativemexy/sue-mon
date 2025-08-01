"use client"

import { useState, useEffect } from "react";
import { useAuth } from "@/contexts/AuthContext";
import { supabase } from "@/integrations/supabase/client";

export const useUserRole = () => {
  const { user } = useAuth();
  const [roles, setRoles] = useState<string[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!user) {
      setRoles([]);
      setLoading(false);
      return;
    }

    const fetchUserRoles = async () => {
      try {
        const { data, error } = await supabase
          .from('user_roles')
          .select('role')
          .eq('user_id', user.id);

        if (error) {
          console.error('Error fetching user roles:', error);
          // Default to user role on any error
          setRoles(['user']);
        } else {
          setRoles(data?.map(r => r.role) || ['user']);
        }
      } catch (error: any) {
        console.error('Exception in fetchUserRoles:', error);
        // Default to user role on any error
        setRoles(['user']);
      } finally {
        setLoading(false);
      }
    };

    fetchUserRoles();
  }, [user]);

  const hasRole = (role: string) => roles.includes(role);
  const isAdmin = hasRole('admin');
  const isModerator = hasRole('moderator');

  return {
    roles,
    hasRole,
    isAdmin,
    isModerator,
    loading
  };
};