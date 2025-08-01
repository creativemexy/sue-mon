"use client"

import { useState } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Badge } from "@/components/ui/badge";
import { Save, Edit, Eye, Phone, Mail, MapPin, Clock, Trash2 } from "lucide-react";
import { useToast } from "@/hooks/use-toast";
import { supabase } from "@/integrations/supabase/client";

interface ContactInfo {
  id: string;
  key: string;
  value: string;
  description?: string;
  created_at: string;
  updated_at: string;
}

interface ContactManagementProps {
  contactInfo: ContactInfo[];
  contactLoading: boolean;
  onRefresh: () => void;
}

export const ContactManagement = ({ contactInfo, contactLoading, onRefresh }: ContactManagementProps) => {
  const [editingContact, setEditingContact] = useState<string | null>(null);
  const [newContact, setNewContact] = useState({
    key: "",
    value: "",
    description: ""
  });
  const { toast } = useToast();

  const handleCreateContact = async () => {
    if (!newContact.key || !newContact.value) {
      toast({
        title: "Error",
        description: "Please fill in required fields",
        variant: "destructive"
      });
      return;
    }

    try {
      const { error } = await supabase
        .from('contact_info')
        .insert(newContact);

      if (error) throw error;

      toast({
        title: "Success",
        description: "Contact information created successfully"
      });

      setNewContact({
        key: "",
        value: "",
        description: ""
      });
      onRefresh();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const handleUpdateContact = async (contactId: string, key: string, value: string, description: string) => {
    try {
      const { error } = await supabase
        .from('contact_info')
        .update({ key, value, description })
        .eq('id', contactId);

      if (error) throw error;

      toast({
        title: "Success",
        description: "Contact information updated successfully"
      });
      setEditingContact(null);
      onRefresh();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const handleDeleteContact = async (contactId: string) => {
    if (!window.confirm("Are you sure you want to delete this contact information?")) return;
    try {
      const { error } = await supabase
        .from('contact_info')
        .delete()
        .eq('id', contactId);

      if (error) throw error;

      toast({
        title: "Success",
        description: "Contact information deleted successfully"
      });
      onRefresh();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const getIcon = (key: string) => {
    switch (key.toLowerCase()) {
      case 'phone':
        return <Phone className="h-4 w-4" />;
      case 'email':
        return <Mail className="h-4 w-4" />;
      case 'address':
        return <MapPin className="h-4 w-4" />;
      case 'hours':
        return <Clock className="h-4 w-4" />;
      default:
        return null;
    }
  };

  return (
    <div className="space-y-6">
      {/* Create New Contact Info */}
      <Card>
        <CardHeader>
          <CardTitle>Add New Contact Information</CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label className="text-sm font-medium">Key *</label>
              <Input
                value={newContact.key}
                onChange={(e) => setNewContact({...newContact, key: e.target.value})}
                placeholder="e.g., phone, email, address, hours"
              />
            </div>
            <div>
              <label className="text-sm font-medium">Value *</label>
              <Input
                value={newContact.value}
                onChange={(e) => setNewContact({...newContact, value: e.target.value})}
                placeholder="e.g., +234 800 TEA SHOP"
              />
            </div>
            <div>
              <label className="text-sm font-medium">Description</label>
              <Input
                value={newContact.description}
                onChange={(e) => setNewContact({...newContact, description: e.target.value})}
                placeholder="Optional description"
              />
            </div>
          </div>
          <Button onClick={handleCreateContact}>
            <Save className="h-4 w-4 mr-2" />
            Add Contact Info
          </Button>
        </CardContent>
      </Card>

      {/* Existing Contact Info */}
      <Card>
        <CardHeader>
          <CardTitle>Manage Contact Information</CardTitle>
        </CardHeader>
        <CardContent>
          {contactLoading ? (
            <div className="text-center py-4">
              <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-primary mx-auto"></div>
              <p className="text-sm text-muted-foreground mt-2">Loading contact info...</p>
            </div>
          ) : (
            <div className="space-y-4">
              {contactInfo.map((contact) => (
                <Card key={contact.id} className="border-l-4 border-l-primary/20">
                  <CardHeader className="pb-2">
                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-3">
                        {getIcon(contact.key)}
                        <div>
                          <CardTitle className="text-lg capitalize">{contact.key}</CardTitle>
                          <p className="text-sm text-muted-foreground">{contact.value}</p>
                          {contact.description && (
                            <p className="text-xs text-muted-foreground mt-1">{contact.description}</p>
                          )}
                        </div>
                      </div>
                      <div className="flex items-center gap-2">
                        <Button
                          variant="outline"
                          size="sm"
                          onClick={() => window.open('/contact', '_blank')}
                        >
                          <Eye className="h-4 w-4" />
                        </Button>
                        <Button
                          variant="outline"
                          size="sm"
                          onClick={() => setEditingContact(editingContact === contact.id ? null : contact.id)}
                        >
                          <Edit className="h-4 w-4" />
                        </Button>
                        <Button
                          variant="outline"
                          size="sm"
                          onClick={() => handleDeleteContact(contact.id)}
                        >
                          <Trash2 className="h-4 w-4" />
                        </Button>
                      </div>
                    </div>
                  </CardHeader>
                  {editingContact === contact.id && (
                    <CardContent className="space-y-4">
                      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                          <label className="text-sm font-medium">Key</label>
                          <Input
                            defaultValue={contact.key}
                            id={`key-${contact.id}`}
                          />
                        </div>
                        <div>
                          <label className="text-sm font-medium">Value</label>
                          <Input
                            defaultValue={contact.value}
                            id={`value-${contact.id}`}
                          />
                        </div>
                        <div>
                          <label className="text-sm font-medium">Description</label>
                          <Input
                            defaultValue={contact.description || ""}
                            id={`description-${contact.id}`}
                          />
                        </div>
                      </div>
                      <Button
                        onClick={() => {
                          const keyInput = document.getElementById(`key-${contact.id}`) as HTMLInputElement;
                          const valueInput = document.getElementById(`value-${contact.id}`) as HTMLInputElement;
                          const descriptionInput = document.getElementById(`description-${contact.id}`) as HTMLInputElement;
                          handleUpdateContact(contact.id, keyInput.value, valueInput.value, descriptionInput.value);
                        }}
                      >
                        <Save className="h-4 w-4 mr-2" />
                        Save Changes
                      </Button>
                    </CardContent>
                  )}
                </Card>
              ))}
            </div>
          )}
        </CardContent>
      </Card>
    </div>
  );
}; 