
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Phone, Mail, MapPin, Clock } from "lucide-react";
import { useState, useEffect } from "react";
import { supabase } from "@/integrations/supabase/client";
import { useToast } from "@/hooks/use-toast";

const Contact = () => {
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    email: "",
    subject: "",
    message: ""
  });
  const [contactInfo, setContactInfo] = useState<any[]>([]);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const { toast } = useToast();

  useEffect(() => {
    fetchContactInfo();
  }, []);

  const fetchContactInfo = async () => {
    try {
      const { data, error } = await supabase
        .from('contact_info')
        .select('*')
        .order('key');

      if (error) throw error;
      setContactInfo(data || []);
    } catch (error) {
      console.error('Error fetching contact info:', error);
      // Fallback to default contact info if database is not set up
      setContactInfo([
        { key: 'phone', value: '+234 800 TEA SHOP' },
        { key: 'email', value: 'hello@suemon.ng' },
        { key: 'address', value: 'Lagos, Nigeria' },
        { key: 'hours', value: 'Mon - Fri: 9:00 AM - 6:00 PM\nSat: 10:00 AM - 4:00 PM\nSun: Closed' }
      ]);
    }
  };

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsSubmitting(true);

    try {
      const { error } = await supabase.functions.invoke('send-contact-email', {
        body: formData
      });

      if (error) throw error;

      toast({
        title: "Message sent!",
        description: "Thank you for your message. We'll get back to you soon.",
      });

      // Reset form
      setFormData({
        firstName: "",
        lastName: "",
        email: "",
        subject: "",
        message: ""
      });
    } catch (error: any) {
      toast({
        title: "Error",
        description: "Failed to send message. Please try again.",
        variant: "destructive",
      });
    } finally {
      setIsSubmitting(false);
    }
  };
  return (
    <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h1 className="text-3xl font-bold text-foreground mb-4">Contact Us</h1>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
          </div>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <Card>
              <CardHeader>
                <CardTitle>Send us a Message</CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <Input 
                      name="firstName"
                      placeholder="First Name" 
                      value={formData.firstName}
                      onChange={handleInputChange}
                      required
                    />
                    <Input 
                      name="lastName"
                      placeholder="Last Name" 
                      value={formData.lastName}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <Input 
                    name="email"
                    placeholder="Email Address" 
                    type="email" 
                    value={formData.email}
                    onChange={handleInputChange}
                    required
                  />
                  <Input 
                    name="subject"
                    placeholder="Subject" 
                    value={formData.subject}
                    onChange={handleInputChange}
                    required
                  />
                  <Textarea 
                    name="message"
                    placeholder="Your Message" 
                    rows={6} 
                    value={formData.message}
                    onChange={handleInputChange}
                    required
                  />
                  <Button type="submit" className="w-full" disabled={isSubmitting}>
                    {isSubmitting ? "Sending..." : "Send Message"}
                  </Button>
                </form>
              </CardContent>
            </Card>

            <div className="space-y-6">
              {contactInfo.map((contact, index) => {
                const getIcon = (key: string) => {
                  switch (key.toLowerCase()) {
                    case 'phone':
                      return <Phone className="h-6 w-6 text-primary" />;
                    case 'email':
                      return <Mail className="h-6 w-6 text-primary" />;
                    case 'address':
                      return <MapPin className="h-6 w-6 text-primary" />;
                    case 'hours':
                      return <Clock className="h-6 w-6 text-primary" />;
                    default:
                      return <Phone className="h-6 w-6 text-primary" />;
                  }
                };

                const getTitle = (key: string) => {
                  switch (key.toLowerCase()) {
                    case 'phone':
                      return 'Phone';
                    case 'email':
                      return 'Email';
                    case 'address':
                      return 'Address';
                    case 'hours':
                      return 'Business Hours';
                    default:
                      return key.charAt(0).toUpperCase() + key.slice(1);
                  }
                };

                return (
                  <Card key={index}>
                    <CardContent className="p-6">
                      <div className="flex items-center space-x-4 mb-4">
                        {getIcon(contact.key)}
                        <div>
                          <h3 className="font-semibold">{getTitle(contact.key)}</h3>
                          {contact.key === 'hours' ? (
                            contact.value.split('\n').map((line: string, i: number) => (
                              <p key={i} className="text-muted-foreground">{line}</p>
                            ))
                          ) : (
                            <p className="text-muted-foreground">{contact.value}</p>
                          )}
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                );
              })}
            </div>
          </div>
        </div>
      </div>
    );
  };

export default Contact;