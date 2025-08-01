"use client"

import { useEffect, useState } from "react";
import { supabase } from "@/integrations/supabase/client";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from "@/components/ui/dialog";
import { Check, Gift, Truck, Calendar, X, CreditCard, Lock } from "lucide-react";
import { useToast } from "@/hooks/use-toast";
import dynamic from 'next/dynamic';

const PaystackButton = dynamic(() => import('react-paystack').then(mod => ({ default: mod.PaystackButton })), {
  ssr: false,
  loading: () => <div className="w-full h-10 bg-muted animate-pulse rounded-md"></div>
});

interface PageContent {
  id: string;
  page_slug: string;
  title: string;
  content: any;
  published: boolean;
}

interface SubscriptionPlan {
  name: string;
  price: string;
  period: string;
  description: string;
  features: string[];
  popular: boolean;
  priceValue: number; // For payment processing
}

interface Benefit {
  icon: string;
  title: string;
  description: string;
}

const Subscription = () => {
  const [pageContent, setPageContent] = useState<PageContent | null>(null);
  const [loading, setLoading] = useState(true);
  const [selectedPlan, setSelectedPlan] = useState<SubscriptionPlan | null>(null);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [subscriptionForm, setSubscriptionForm] = useState({
    email: "",
    name: "",
    phone: "",
    address: ""
  });
  const [isSubscribing, setIsSubscribing] = useState(false);
  const [showPayment, setShowPayment] = useState(false);
  const { toast } = useToast();

  // Replace with your actual Paystack public key
  const publicKey = "pk_test_your_paystack_public_key_here";

  // Default static content as fallback
  const defaultPlans: SubscriptionPlan[] = [
    {
      name: "Starter Plan",
      price: "₦8,500",
      priceValue: 8500,
      period: "per month",
      description: "Perfect for tea beginners",
      features: [
        "3 different tea blends (50g each)",
        "Monthly wellness guide",
        "Free shipping",
        "Cancel anytime"
      ],
      popular: false
    },
    {
      name: "Explorer Plan", 
      price: "₦14,000",
      priceValue: 14000,
      period: "per month",
      description: "For the curious tea enthusiast",
      features: [
        "5 different tea blends (50g each)",
        "Exclusive seasonal blends",
        "Monthly wellness guide",
        "Tea brewing accessories",
        "Free shipping",
        "Cancel anytime"
      ],
      popular: true
    },
    {
      name: "Connoisseur Plan",
      price: "₦22,000", 
      priceValue: 22000,
      period: "per month",
      description: "For the ultimate tea lover",
      features: [
        "8 different tea blends (50g each)",
        "Premium exclusive blends",
        "Monthly wellness guide",
        "Premium brewing accessories",
        "Personal tea consultation",
        "Free shipping",
        "Cancel anytime"
      ],
      popular: false
    }
  ];

  const defaultBenefits = [
    {
      icon: "Gift",
      title: "Curated Selection",
      description: "Hand-picked premium blends delivered to your door"
    },
    {
      icon: "Truck",
      title: "Free Delivery",
      description: "Free shipping on all subscription orders"
    },
    {
      icon: "Calendar",
      title: "Flexible Schedule",
      description: "Pause, skip, or cancel your subscription anytime"
    }
  ];

  useEffect(() => {
    const fetchPageContent = async () => {
      try {
        // Check if supabase is properly initialized
        if (!supabase) {
          console.log('Supabase client not available, using static content');
          setPageContent(null);
          setLoading(false);
          return;
        }

        const { data, error } = await supabase
          .from('page_content')
          .select('*')
          .eq('page_slug', 'subscription')
          .eq('published', true)
          .single();

        if (error) {
          // Check if it's a table doesn't exist error (42P01)
          if (error.code === '42P01') {
            console.log('page_content table does not exist, using static content');
            setPageContent(null);
          } else {
            console.log('No dynamic content found, using static content');
            setPageContent(null);
          }
        } else {
          setPageContent(data);
        }
      } catch (error: any) {
        console.error('Error fetching subscription page content:', error);
        setPageContent(null);
      } finally {
        setLoading(false);
      }
    };

    fetchPageContent();
  }, []);

  const handleSubscribe = (plan: SubscriptionPlan) => {
    setSelectedPlan(plan);
    setIsModalOpen(true);
  };

  const handleSubscriptionSubmit = () => {
    if (!selectedPlan) return;

    // Validate form
    if (!subscriptionForm.email || !subscriptionForm.name || !subscriptionForm.phone) {
      toast({
        title: "Error",
        description: "Please fill in all required fields",
        variant: "destructive"
      });
      return;
    }

    // Show payment section
    setShowPayment(true);
  };

  const handlePaymentSuccess = async (reference: any) => {
    setIsSubscribing(true);

    try {
      // Save subscription to database
      const { error } = await supabase
        .from('subscriptions')
        .insert({
          email: subscriptionForm.email,
          name: subscriptionForm.name,
          phone: subscriptionForm.phone,
          address: subscriptionForm.address,
          plan_name: selectedPlan?.name,
          plan_price: selectedPlan?.priceValue,
          status: 'active',
          start_date: new Date().toISOString(),
          payment_reference: reference.reference
        });

      if (error) {
        console.log('Subscriptions table may not exist, but payment was successful');
      }

      toast({
        title: "Payment Successful!",
        description: `You have successfully subscribed to the ${selectedPlan?.name}. Welcome to Sue&Mon!`,
      });

      // Reset form and close modal
      setSubscriptionForm({
        email: "",
        name: "",
        phone: "",
        address: ""
      });
      setIsModalOpen(false);
      setSelectedPlan(null);
      setShowPayment(false);

    } catch (error) {
      console.error('Subscription error:', error);
      toast({
        title: "Error",
        description: "Payment successful but failed to save subscription. Please contact support.",
        variant: "destructive"
      });
    } finally {
      setIsSubscribing(false);
    }
  };

  const handlePaymentClose = () => {
    toast({
      title: "Payment Cancelled",
      description: "Your payment was cancelled",
      variant: "destructive",
    });
    setShowPayment(false);
  };

  if (loading) {
    return (
      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <div className="animate-pulse">
              <div className="h-8 bg-muted rounded w-1/3 mx-auto mb-4"></div>
              <div className="h-4 bg-muted rounded w-2/3 mx-auto"></div>
            </div>
          </div>
        </div>
      </div>
    );
  }

  // If we have dynamic content, render it with event handlers
  if (pageContent && pageContent.content) {
    return (
      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div 
            dangerouslySetInnerHTML={{ __html: pageContent.content.html || pageContent.content }}
            ref={(el) => {
              if (el) {
                // Add click handlers to Subscribe Now buttons
                const buttons = el.querySelectorAll('button');
                buttons.forEach(button => {
                  if (button.textContent?.includes('Subscribe Now')) {
                    button.addEventListener('click', () => {
                      // Find the plan details from the card
                      const card = button.closest('.relative') || button.closest('[class*="border"]');
                      const planName = card?.querySelector('.text-xl')?.textContent || 
                                     card?.querySelector('[class*="font-semibold"]')?.textContent || 'Unknown Plan';
                      const priceText = card?.querySelector('.text-3xl')?.textContent || '₦0';
                      const priceValue = parseInt(priceText.replace(/[^0-9]/g, '')) || 0;
                      
                      // Create plan object
                      const plan = {
                        name: planName,
                        price: priceText,
                        priceValue: priceValue,
                        period: 'per month',
                        description: card?.querySelector('.text-muted-foreground')?.textContent || '',
                        features: [],
                        popular: card?.classList.contains('border-primary') || false
                      };
                      
                      setSelectedPlan(plan);
                      setIsModalOpen(true);
                    });
                  }
                });
              }
            }}
          />
        </div>
        
        {/* Subscription Modal for dynamic content */}
        <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
          <DialogContent className="sm:max-w-[500px]">
            <DialogHeader>
              <DialogTitle>Subscribe to {selectedPlan?.name}</DialogTitle>
              <DialogDescription>
                Complete your subscription details below. You can cancel anytime.
              </DialogDescription>
            </DialogHeader>
            
            <div className="space-y-4">
              <div>
                <Label htmlFor="name">Full Name *</Label>
                <Input
                  id="name"
                  value={subscriptionForm.name}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, name: e.target.value})}
                  placeholder="Enter your full name"
                  required
                />
              </div>
              
              <div>
                <Label htmlFor="email">Email Address *</Label>
                <Input
                  id="email"
                  type="email"
                  value={subscriptionForm.email}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, email: e.target.value})}
                  placeholder="Enter your email"
                  required
                />
              </div>
              
              <div>
                <Label htmlFor="phone">Phone Number *</Label>
                <Input
                  id="phone"
                  type="tel"
                  value={subscriptionForm.phone}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, phone: e.target.value})}
                  placeholder="Enter your phone number"
                  required
                />
              </div>
              
              <div>
                <Label htmlFor="address">Delivery Address</Label>
                <Input
                  id="address"
                  value={subscriptionForm.address}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, address: e.target.value})}
                  placeholder="Enter your delivery address"
                />
              </div>

              {selectedPlan && (
                <div className="bg-muted p-4 rounded-lg">
                  <h4 className="font-semibold mb-2">Subscription Summary</h4>
                  <div className="flex justify-between items-center">
                    <span>{selectedPlan.name}</span>
                    <span className="font-bold">{selectedPlan.price}/{selectedPlan.period}</span>
                  </div>
                  <p className="text-sm text-muted-foreground mt-2">
                    Your first delivery will be processed immediately.
                  </p>
                </div>
              )}

              {/* Payment Section */}
              {showPayment && selectedPlan && (
                <div className="border-t pt-4">
                  <div className="flex items-center justify-center space-x-2 mb-3">
                    <Lock className="h-4 w-4 text-muted-foreground" />
                    <span className="text-sm text-muted-foreground">
                      Secured by Paystack
                    </span>
                  </div>

                  <PaystackButton
                    email={subscriptionForm.email}
                    amount={selectedPlan.priceValue * 100} // Paystack expects amount in kobo
                    currency="NGN"
                    publicKey={publicKey}
                    text={`Pay ${selectedPlan.price}`}
                    onSuccess={handlePaymentSuccess}
                    onClose={handlePaymentClose}
                    className="w-full bg-primary hover:bg-primary/90 text-primary-foreground font-medium py-2 px-4 rounded-md transition-colors duration-200 flex items-center justify-center space-x-2"
                  >
                    <CreditCard className="h-4 w-4" />
                    <span>Pay {selectedPlan.price}</span>
                  </PaystackButton>

                  <p className="text-xs text-muted-foreground text-center mt-3">
                    By proceeding, you agree to our Terms of Service and Privacy Policy.
                    Your payment is processed securely through Paystack.
                  </p>
                </div>
              )}
            </div>

            <div className="flex justify-end space-x-2 pt-4">
              <Button 
                variant="outline" 
                onClick={() => {
                  setIsModalOpen(false);
                  setShowPayment(false);
                }}
                disabled={isSubscribing}
              >
                Cancel
              </Button>
              {!showPayment ? (
                <Button 
                  onClick={handleSubscriptionSubmit}
                  disabled={isSubscribing}
                >
                  Continue to Payment
                </Button>
              ) : (
                <div className="flex items-center space-x-2">
                  <Lock className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm text-muted-foreground">
                    Secured by Paystack
                  </span>
                </div>
              )}
            </div>
          </DialogContent>
        </Dialog>
      </div>
    );
  }

  // Fallback to static content
  const plans = defaultPlans;
  const benefits = defaultBenefits;

  const getIconComponent = (iconName: string) => {
    const iconMap: { [key: string]: any } = {
      Gift,
      Truck,
      Calendar,
      Check
    };
    return iconMap[iconName] || Gift;
  };

  return (
    <div className="py-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <h1 className="text-3xl font-bold text-foreground mb-4">Tea Subscription</h1>
          <p className="text-muted-foreground max-w-2xl mx-auto">
            Get premium herbal tea blends delivered monthly. Discover new flavors and enjoy the convenience of automatic delivery.
          </p>
        </div>

        {/* Benefits */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
          {benefits.map((benefit, index) => {
            const IconComponent = getIconComponent(benefit.icon);
            return (
              <div key={index} className="text-center">
                <div className="bg-gradient-hero p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                  <IconComponent className="h-8 w-8 text-primary-foreground" />
                </div>
                <h3 className="font-semibold text-foreground mb-2">{benefit.title}</h3>
                <p className="text-muted-foreground">{benefit.description}</p>
              </div>
            );
          })}
        </div>

        {/* Subscription Plans */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {plans.map((plan, index) => (
            <Card key={index} className={`relative ${plan.popular ? 'border-primary shadow-elegant' : ''}`}>
              {plan.popular && (
                <Badge className="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-secondary">
                  Most Popular
                </Badge>
              )}
              <CardHeader>
                <CardTitle className="text-xl">{plan.name}</CardTitle>
                <CardDescription>{plan.description}</CardDescription>
                <div className="pt-4">
                  <span className="text-3xl font-bold text-foreground">{plan.price}</span>
                  <span className="text-muted-foreground ml-2">{plan.period}</span>
                </div>
              </CardHeader>
              <CardContent>
                <ul className="space-y-3 mb-6">
                  {plan.features.map((feature, featureIndex) => (
                    <li key={featureIndex} className="flex items-center space-x-3">
                      <Check className="h-4 w-4 text-primary" />
                      <span className="text-muted-foreground">{feature}</span>
                    </li>
                  ))}
                </ul>
                <Button 
                  className="w-full" 
                  variant={plan.popular ? "default" : "outline"}
                  onClick={() => handleSubscribe(plan)}
                >
                  Subscribe Now
                </Button>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* Subscription Modal */}
        <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
          <DialogContent className="sm:max-w-[500px]">
            <DialogHeader>
              <DialogTitle>Subscribe to {selectedPlan?.name}</DialogTitle>
              <DialogDescription>
                Complete your subscription details below. You can cancel anytime.
              </DialogDescription>
            </DialogHeader>
            
            <div className="space-y-4">
              <div>
                <Label htmlFor="name">Full Name *</Label>
                <Input
                  id="name"
                  value={subscriptionForm.name}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, name: e.target.value})}
                  placeholder="Enter your full name"
                  required
                />
              </div>
              
              <div>
                <Label htmlFor="email">Email Address *</Label>
                <Input
                  id="email"
                  type="email"
                  value={subscriptionForm.email}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, email: e.target.value})}
                  placeholder="Enter your email"
                  required
                />
              </div>
              
              <div>
                <Label htmlFor="phone">Phone Number *</Label>
                <Input
                  id="phone"
                  type="tel"
                  value={subscriptionForm.phone}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, phone: e.target.value})}
                  placeholder="Enter your phone number"
                  required
                />
              </div>
              
              <div>
                <Label htmlFor="address">Delivery Address</Label>
                <Input
                  id="address"
                  value={subscriptionForm.address}
                  onChange={(e) => setSubscriptionForm({...subscriptionForm, address: e.target.value})}
                  placeholder="Enter your delivery address"
                />
              </div>

              {selectedPlan && (
                <div className="bg-muted p-4 rounded-lg">
                  <h4 className="font-semibold mb-2">Subscription Summary</h4>
                  <div className="flex justify-between items-center">
                    <span>{selectedPlan.name}</span>
                    <span className="font-bold">{selectedPlan.price}/{selectedPlan.period}</span>
                  </div>
                  <p className="text-sm text-muted-foreground mt-2">
                    Your first delivery will be processed immediately.
                  </p>
                </div>
              )}
            </div>

            <div className="flex justify-end space-x-2 pt-4">
              <Button 
                variant="outline" 
                onClick={() => {
                  setIsModalOpen(false);
                  setShowPayment(false);
                }}
                disabled={isSubscribing}
              >
                Cancel
              </Button>
              {!showPayment ? (
                <Button 
                  onClick={handleSubscriptionSubmit}
                  disabled={isSubscribing}
                >
                  Continue to Payment
                </Button>
              ) : (
                <div className="flex items-center space-x-2">
                  <Lock className="h-4 w-4 text-muted-foreground" />
                  <span className="text-sm text-muted-foreground">
                    Secured by Paystack
                  </span>
                </div>
              )}
            </div>
          </DialogContent>
        </Dialog>
      </div>
    </div>
  );
};

export default Subscription;