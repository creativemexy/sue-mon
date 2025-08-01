import { z } from 'zod';

// Contact form validation
export const contactFormSchema = z.object({
  name: z.string().min(2, 'Name must be at least 2 characters'),
  email: z.string().email('Please enter a valid email address'),
  subject: z.string().min(5, 'Subject must be at least 5 characters'),
  message: z.string().min(10, 'Message must be at least 10 characters')
});

// Newsletter subscription validation
export const newsletterSchema = z.object({
  email: z.string().email('Please enter a valid email address')
});

// User registration validation
export const registerSchema = z.object({
  email: z.string().email('Please enter a valid email address'),
  password: z.string().min(8, 'Password must be at least 8 characters'),
  confirmPassword: z.string()
}).refine((data) => data.password === data.confirmPassword, {
  message: "Passwords don't match",
  path: ["confirmPassword"]
});

// User login validation
export const loginSchema = z.object({
  email: z.string().email('Please enter a valid email address'),
  password: z.string().min(1, 'Password is required')
});

// Checkout form validation
export const checkoutSchema = z.object({
  firstName: z.string().min(2, 'First name must be at least 2 characters'),
  lastName: z.string().min(2, 'Last name must be at least 2 characters'),
  email: z.string().email('Please enter a valid email address'),
  phone: z.string().min(10, 'Please enter a valid phone number'),
  address: z.string().min(10, 'Please enter a complete address'),
  city: z.string().min(2, 'City is required'),
  state: z.string().min(2, 'State is required'),
  postalCode: z.string().min(3, 'Postal code is required'),
  country: z.string().min(2, 'Country is required')
});

// Product review validation
export const reviewSchema = z.object({
  rating: z.number().min(1).max(5),
  title: z.string().min(5, 'Review title must be at least 5 characters'),
  comment: z.string().min(10, 'Review comment must be at least 10 characters')
});

// Search validation
export const searchSchema = z.object({
  query: z.string().min(1, 'Search query is required')
});

// Type exports
export type ContactFormData = z.infer<typeof contactFormSchema>;
export type NewsletterData = z.infer<typeof newsletterSchema>;
export type RegisterData = z.infer<typeof registerSchema>;
export type LoginData = z.infer<typeof loginSchema>;
export type CheckoutData = z.infer<typeof checkoutSchema>;
export type ReviewData = z.infer<typeof reviewSchema>;
export type SearchData = z.infer<typeof searchSchema>; 