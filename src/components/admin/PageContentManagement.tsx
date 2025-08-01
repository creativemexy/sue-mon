"use client"

import { useState, useEffect } from "react";
import { supabase } from "@/integrations/supabase/client";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { useToast } from "@/hooks/use-toast";
import { Plus, Edit, Trash2, Eye, Save, X } from "lucide-react";

interface PageContent {
  id: string;
  page_slug: string;
  title: string;
  content: any;
  published: boolean;
  created_at: string;
  updated_at: string;
}

const PageContentManagement = () => {
  const [pages, setPages] = useState<PageContent[]>([]);
  const [loading, setLoading] = useState(true);
  const [editingPage, setEditingPage] = useState<PageContent | null>(null);
  const [newPage, setNewPage] = useState({
    page_slug: "",
    title: "",
    content: "",
    published: false
  });
  const [showNewForm, setShowNewForm] = useState(false);
  const { toast } = useToast();

  useEffect(() => {
    fetchPages();
  }, []);

  const fetchPages = async () => {
    try {
      const { data, error } = await supabase
        .from('page_content')
        .select('*')
        .order('created_at', { ascending: false });

      if (error) {
        if (error.code === '42P01') {
          console.log('Page content table does not exist yet');
          setPages([]);
        } else {
          throw error;
        }
      } else {
        setPages(data || []);
      }
    } catch (error: any) {
      console.error('Error fetching pages:', error);
      if (error.code !== '42P01') {
        toast({
          title: "Error",
          description: "Failed to fetch pages",
          variant: "destructive"
        });
      }
      setPages([]);
    } finally {
      setLoading(false);
    }
  };

  const handleCreatePage = async () => {
    if (!newPage.page_slug || !newPage.title || !newPage.content) {
      toast({
        title: "Error",
        description: "Please fill in all required fields",
        variant: "destructive"
      });
      return;
    }

    try {
      const { error } = await supabase
        .from('page_content')
        .insert({
          page_slug: newPage.page_slug.toLowerCase().replace(/\s+/g, '-'),
          title: newPage.title,
          content: { html: newPage.content },
          published: newPage.published
        });

      if (error) throw error;

      toast({
        title: "Success",
        description: "Page created successfully"
      });

      setNewPage({ page_slug: "", title: "", content: "", published: false });
      setShowNewForm(false);
      fetchPages();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const handleUpdatePage = async () => {
    if (!editingPage) return;

    try {
      const { error } = await supabase
        .from('page_content')
        .update({
          title: editingPage.title,
          content: { html: editingPage.content },
          published: editingPage.published
        })
        .eq('id', editingPage.id);

      if (error) throw error;

      toast({
        title: "Success",
        description: "Page updated successfully"
      });

      setEditingPage(null);
      fetchPages();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const handleDeletePage = async (pageId: string) => {
    if (!confirm("Are you sure you want to delete this page?")) return;

    try {
      const { error } = await supabase
        .from('page_content')
        .delete()
        .eq('id', pageId);

      if (error) throw error;

      toast({
        title: "Success",
        description: "Page deleted successfully"
      });

      fetchPages();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const handleTogglePublished = async (pageId: string, published: boolean) => {
    try {
      const { error } = await supabase
        .from('page_content')
        .update({ published: !published })
        .eq('id', pageId);

      if (error) throw error;

      toast({
        title: "Success",
        description: `Page ${!published ? 'published' : 'unpublished'} successfully`
      });

      fetchPages();
    } catch (error: any) {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive"
      });
    }
  };

  const getContentPreview = (content: any) => {
    if (typeof content === 'string') return content;
    if (content.html) return content.html;
    if (content.text) return content.text;
    return JSON.stringify(content).substring(0, 100) + "...";
  };

  if (loading) {
    return (
      <div className="space-y-4">
        <div className="animate-pulse">
          <div className="h-8 bg-muted rounded w-1/3 mb-4"></div>
          <div className="h-4 bg-muted rounded w-2/3"></div>
        </div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <div>
          <h3 className="text-lg font-semibold">Page Content Management</h3>
          <p className="text-sm text-muted-foreground">
            Manage dynamic page content like About, Contact, and other pages
          </p>
        </div>
        <Button onClick={() => setShowNewForm(true)}>
          <Plus className="h-4 w-4 mr-2" />
          Add Page
        </Button>
      </div>

      {/* New Page Form */}
      {showNewForm && (
        <Card>
          <CardHeader>
            <div className="flex justify-between items-center">
              <CardTitle>Create New Page</CardTitle>
              <Button variant="ghost" size="sm" onClick={() => setShowNewForm(false)}>
                <X className="h-4 w-4" />
              </Button>
            </div>
          </CardHeader>
          <CardContent className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="text-sm font-medium">Page Slug</label>
                <Input
                  placeholder="about, contact, etc."
                  value={newPage.page_slug}
                  onChange={(e) => setNewPage({ ...newPage, page_slug: e.target.value })}
                />
              </div>
              <div>
                <label className="text-sm font-medium">Title</label>
                <Input
                  placeholder="Page title"
                  value={newPage.title}
                  onChange={(e) => setNewPage({ ...newPage, title: e.target.value })}
                />
              </div>
            </div>
            <div>
              <label className="text-sm font-medium">Content (HTML)</label>
              <Textarea
                placeholder="Enter HTML content..."
                value={newPage.content}
                onChange={(e) => setNewPage({ ...newPage, content: e.target.value })}
                rows={10}
              />
            </div>
            <div className="flex items-center space-x-2">
              <input
                type="checkbox"
                id="new-published"
                checked={newPage.published}
                onChange={(e) => setNewPage({ ...newPage, published: e.target.checked })}
              />
              <label htmlFor="new-published" className="text-sm">Published</label>
            </div>
            <div className="flex space-x-2">
              <Button onClick={handleCreatePage}>
                <Save className="h-4 w-4 mr-2" />
                Create Page
              </Button>
              <Button variant="outline" onClick={() => setShowNewForm(false)}>
                Cancel
              </Button>
            </div>
          </CardContent>
        </Card>
      )}

      {/* Pages List */}
      <div className="space-y-4">
        {pages.length === 0 ? (
          <Card>
            <CardContent className="py-8">
              <div className="text-center">
                <p className="text-muted-foreground">No pages found. Create your first page above.</p>
              </div>
            </CardContent>
          </Card>
        ) : (
          pages.map((page) => (
            <Card key={page.id}>
              <CardHeader>
                <div className="flex justify-between items-start">
                  <div>
                    <CardTitle className="flex items-center space-x-2">
                      {page.title}
                      {page.published ? (
                        <Badge variant="default">Published</Badge>
                      ) : (
                        <Badge variant="secondary">Draft</Badge>
                      )}
                    </CardTitle>
                    <CardDescription>
                      Slug: /{page.page_slug} • Updated: {new Date(page.updated_at).toLocaleDateString()}
                    </CardDescription>
                  </div>
                  <div className="flex space-x-2">
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => setEditingPage(page)}
                    >
                      <Edit className="h-4 w-4" />
                    </Button>
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => handleTogglePublished(page.id, page.published)}
                    >
                      {page.published ? "Unpublish" : "Publish"}
                    </Button>
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => window.open(`/${page.page_slug}`, '_blank')}
                    >
                      <Eye className="h-4 w-4" />
                    </Button>
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => handleDeletePage(page.id)}
                    >
                      <Trash2 className="h-4 w-4" />
                    </Button>
                  </div>
                </div>
              </CardHeader>
              <CardContent>
                <div className="bg-muted p-3 rounded text-sm">
                  <strong>Preview:</strong>
                  <div className="mt-2 text-muted-foreground">
                    {getContentPreview(page.content)}
                  </div>
                </div>
              </CardContent>
            </Card>
          ))
        )}
      </div>

      {/* Edit Modal */}
      {editingPage && (
        <Card className="fixed inset-4 z-50 overflow-y-auto bg-background border">
          <CardHeader>
            <div className="flex justify-between items-center">
              <CardTitle>Edit Page: {editingPage.title}</CardTitle>
              <Button variant="ghost" size="sm" onClick={() => setEditingPage(null)}>
                <X className="h-4 w-4" />
              </Button>
            </div>
          </CardHeader>
          <CardContent className="space-y-4">
            <div>
              <label className="text-sm font-medium">Title</label>
              <Input
                value={editingPage.title}
                onChange={(e) => setEditingPage({ ...editingPage, title: e.target.value })}
              />
            </div>
            <div>
              <label className="text-sm font-medium">Content (HTML)</label>
              <Textarea
                value={typeof editingPage.content === 'string' ? editingPage.content : 
                       editingPage.content?.html || editingPage.content?.text || ''}
                onChange={(e) => setEditingPage({ ...editingPage, content: e.target.value })}
                rows={15}
              />
            </div>
            <div className="flex items-center space-x-2">
              <input
                type="checkbox"
                id="edit-published"
                checked={editingPage.published}
                onChange={(e) => setEditingPage({ ...editingPage, published: e.target.checked })}
              />
              <label htmlFor="edit-published" className="text-sm">Published</label>
            </div>
            <div className="flex space-x-2">
              <Button onClick={handleUpdatePage}>
                <Save className="h-4 w-4 mr-2" />
                Update Page
              </Button>
              <Button variant="outline" onClick={() => setEditingPage(null)}>
                Cancel
              </Button>
            </div>
          </CardContent>
        </Card>
      )}
    </div>
  );
};

export default PageContentManagement; 