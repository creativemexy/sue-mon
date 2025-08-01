import { supabase } from '@/integrations/supabase/client';
import type { ApiResponse } from '@/types';

// Generic API error handler
export const handleApiError = (error: any): string => {
  if (typeof error === 'string') return error;
  if (error?.message) return error.message;
  if (error?.error_description) return error.error_description;
  return 'An unexpected error occurred';
};

// Generic API response wrapper
export const createApiResponse = <T>(
  data: T | null = null,
  error: string | null = null
): ApiResponse<T> => ({
  data,
  error,
  success: !error
});

// Supabase API helpers
export const supabaseApi = {
  // Products
  async getProducts() {
    try {
      const { data, error } = await supabase
        .from('products')
        .select('*')
        .eq('is_active', true)
        .order('created_at', { ascending: false });

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  async getFeaturedProducts() {
    try {
      const { data, error } = await supabase
        .from('products')
        .select('*')
        .eq('is_active', true)
        .eq('featured', true)
        .order('created_at', { ascending: false });

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  async getProductById(id: string) {
    try {
      const { data, error } = await supabase
        .from('products')
        .select('*')
        .eq('id', id)
        .eq('is_active', true)
        .single();

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  // Blog posts
  async getBlogPosts() {
    try {
      const { data, error } = await supabase
        .from('blog_posts')
        .select('*')
        .eq('published', true)
        .order('created_at', { ascending: false });

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  async getBlogPostById(id: string) {
    try {
      const { data, error } = await supabase
        .from('blog_posts')
        .select('*')
        .eq('id', id)
        .eq('published', true)
        .single();

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  // Orders
  async createOrder(orderData: any) {
    try {
      const { data, error } = await supabase
        .from('orders')
        .insert([orderData])
        .select()
        .single();

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  async getOrderByReference(reference: string) {
    try {
      const { data, error } = await supabase
        .from('orders')
        .select('*')
        .eq('payment_reference', reference)
        .single();

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  // Contact form
  async submitContactForm(formData: any) {
    try {
      const { data, error } = await supabase
        .from('contact_submissions')
        .insert([formData])
        .select()
        .single();

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  },

  // Newsletter subscription
  async subscribeToNewsletter(email: string) {
    try {
      const { data, error } = await supabase
        .from('newsletter_subscriptions')
        .insert([{ email }])
        .select()
        .single();

      if (error) throw error;
      return createApiResponse(data);
    } catch (error) {
      return createApiResponse(null, handleApiError(error));
    }
  }
}; 