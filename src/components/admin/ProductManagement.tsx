"use client"

import { useState, useEffect } from "react";
import { supabase } from "@/integrations/supabase/client";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Badge } from "@/components/ui/badge";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from "@/components/ui/dialog";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Switch } from "@/components/ui/switch";
import { useToast } from "@/hooks/use-toast";
import { Plus, Edit, Trash2, Star } from "lucide-react";

interface Product {
  id: string;
  name: string;
  description: string;
  price: number;
  original_price?: number;
  image: string;
  rating: number;
  reviews: number;
  benefits: string[];
  category: string;
  in_stock: boolean;
  is_new: boolean;
  is_bestseller: boolean;
}

const ProductManagement = () => {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [editingProduct, setEditingProduct] = useState<Product | null>(null);
  const { toast } = useToast();

  const [formData, setFormData] = useState({
    name: "",
    description: "",
    price: "",
    original_price: "",
    image: "/placeholder.svg",
    rating: "0.0",
    reviews: "0",
    benefits: [] as string[],
    category: "immunity",
    in_stock: true,
    is_new: false,
    is_bestseller: false
  });

  const categories = [
    { value: "immunity", label: "Immunity" },
    { value: "energy", label: "Energy" },
    { value: "heart", label: "Heart Health" },
    { value: "culinary", label: "Culinary" },
    { value: "sleep", label: "Sleep" },
    { value: "traditional", label: "Traditional" }
  ];

  const fetchProducts = async () => {
    try {
      if (!supabase) {
        setLoading(false);
        return;
      }

      const { data, error } = await supabase
        .from('products')
        .select('*')
        .order('created_at', { ascending: false });

      if (error) {
        console.log('products table does not exist');
        setProducts([]);
      } else {
        setProducts(data || []);
      }
    } catch (error) {
      console.error('Error fetching products:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);

  const resetForm = () => {
    setFormData({
      name: "",
      description: "",
      price: "",
      original_price: "",
      image: "/placeholder.svg",
      rating: "0.0",
      reviews: "0",
      benefits: [],
      category: "immunity",
      in_stock: true,
      is_new: false,
      is_bestseller: false
    });
    setEditingProduct(null);
  };

  const handleSubmit = async () => {
    if (!formData.name || !formData.description || !formData.price) {
      toast({
        title: "Error",
        description: "Please fill in all required fields",
        variant: "destructive"
      });
      return;
    }

    try {
      const productData = {
        name: formData.name,
        description: formData.description,
        price: parseInt(formData.price),
        original_price: formData.original_price ? parseInt(formData.original_price) : null,
        image: formData.image,
        rating: parseFloat(formData.rating),
        reviews: parseInt(formData.reviews),
        benefits: formData.benefits,
        category: formData.category,
        in_stock: formData.in_stock,
        is_new: formData.is_new,
        is_bestseller: formData.is_bestseller
      };

      if (editingProduct) {
        await supabase
          .from('products')
          .update(productData)
          .eq('id', editingProduct.id);
      } else {
        await supabase
          .from('products')
          .insert(productData);
      }

      toast({
        title: "Success",
        description: editingProduct ? "Product updated successfully" : "Product added successfully"
      });

      setIsDialogOpen(false);
      resetForm();
      fetchProducts();
    } catch (error: any) {
      toast({
        title: "Error",
        description: "Failed to save product",
        variant: "destructive"
      });
    }
  };

  const handleEdit = (product: Product) => {
    setEditingProduct(product);
    setFormData({
      name: product.name,
      description: product.description,
      price: product.price.toString(),
      original_price: product.original_price?.toString() || "",
      image: product.image,
      rating: product.rating.toString(),
      reviews: product.reviews.toString(),
      benefits: product.benefits,
      category: product.category,
      in_stock: product.in_stock,
      is_new: product.is_new,
      is_bestseller: product.is_bestseller
    });
    setIsDialogOpen(true);
  };

  const handleDelete = async (productId: string) => {
    if (!confirm("Are you sure you want to delete this product?")) return;

    try {
      await supabase
        .from('products')
        .delete()
        .eq('id', productId);

      toast({
        title: "Success",
        description: "Product deleted successfully"
      });
      fetchProducts();
    } catch (error: any) {
      toast({
        title: "Error",
        description: "Failed to delete product",
        variant: "destructive"
      });
    }
  };

  if (loading) {
    return <div>Loading products...</div>;
  }

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <div>
          <h2 className="text-2xl font-bold">Product Management</h2>
          <p className="text-muted-foreground">Manage your tea and spice products</p>
        </div>
        <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
          <DialogTrigger asChild>
            <Button onClick={() => resetForm()}>
              <Plus className="h-4 w-4 mr-2" />
              Add Product
            </Button>
          </DialogTrigger>
          <DialogContent className="max-w-2xl">
            <DialogHeader>
              <DialogTitle>
                {editingProduct ? "Edit Product" : "Add New Product"}
              </DialogTitle>
            </DialogHeader>
            
            <div className="space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <Label htmlFor="name">Product Name *</Label>
                  <Input
                    id="name"
                    value={formData.name}
                    onChange={(e) => setFormData({...formData, name: e.target.value})}
                    placeholder="Enter product name"
                  />
                </div>
                <div>
                  <Label htmlFor="category">Category *</Label>
                  <Select value={formData.category} onValueChange={(value) => setFormData({...formData, category: value})}>
                    <SelectTrigger>
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      {categories.map((category) => (
                        <SelectItem key={category.value} value={category.value}>
                          {category.label}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>
              </div>

              <div>
                <Label htmlFor="description">Description *</Label>
                <Textarea
                  id="description"
                  value={formData.description}
                  onChange={(e) => setFormData({...formData, description: e.target.value})}
                  placeholder="Enter product description"
                  rows={3}
                />
              </div>

              <div className="grid grid-cols-3 gap-4">
                <div>
                  <Label htmlFor="price">Price (₦) *</Label>
                  <Input
                    id="price"
                    type="number"
                    value={formData.price}
                    onChange={(e) => setFormData({...formData, price: e.target.value})}
                    placeholder="0"
                  />
                </div>
                <div>
                  <Label htmlFor="original_price">Original Price (₦)</Label>
                  <Input
                    id="original_price"
                    type="number"
                    value={formData.original_price}
                    onChange={(e) => setFormData({...formData, original_price: e.target.value})}
                    placeholder="0"
                  />
                </div>
                <div>
                  <Label htmlFor="image">Image URL</Label>
                  <Input
                    id="image"
                    value={formData.image}
                    onChange={(e) => setFormData({...formData, image: e.target.value})}
                    placeholder="/placeholder.svg"
                  />
                </div>
              </div>

              <div className="grid grid-cols-3 gap-4">
                <div>
                  <Label htmlFor="rating">Rating</Label>
                  <Input
                    id="rating"
                    type="number"
                    step="0.1"
                    min="0"
                    max="5"
                    value={formData.rating}
                    onChange={(e) => setFormData({...formData, rating: e.target.value})}
                    placeholder="0.0"
                  />
                </div>
                <div>
                  <Label htmlFor="reviews">Reviews</Label>
                  <Input
                    id="reviews"
                    type="number"
                    value={formData.reviews}
                    onChange={(e) => setFormData({...formData, reviews: e.target.value})}
                    placeholder="0"
                  />
                </div>
                <div className="flex items-center space-x-2">
                  <Switch
                    id="in_stock"
                    checked={formData.in_stock}
                    onCheckedChange={(checked) => setFormData({...formData, in_stock: checked})}
                  />
                  <Label htmlFor="in_stock">In Stock</Label>
                </div>
              </div>

              <div className="flex items-center space-x-4">
                <div className="flex items-center space-x-2">
                  <Switch
                    id="is_new"
                    checked={formData.is_new}
                    onCheckedChange={(checked) => setFormData({...formData, is_new: checked})}
                  />
                  <Label htmlFor="is_new">New Product</Label>
                </div>
                <div className="flex items-center space-x-2">
                  <Switch
                    id="is_bestseller"
                    checked={formData.is_bestseller}
                    onCheckedChange={(checked) => setFormData({...formData, is_bestseller: checked})}
                  />
                  <Label htmlFor="is_bestseller">Bestseller</Label>
                </div>
              </div>
            </div>

            <div className="flex justify-end space-x-2 pt-4">
              <Button variant="outline" onClick={() => setIsDialogOpen(false)}>
                Cancel
              </Button>
              <Button onClick={handleSubmit}>
                {editingProduct ? "Update Product" : "Add Product"}
              </Button>
            </div>
          </DialogContent>
        </Dialog>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {products.map((product) => (
          <Card key={product.id} className="relative">
            <CardHeader>
              <div className="flex justify-between items-start">
                <div className="flex-1">
                  <CardTitle className="text-lg">{product.name}</CardTitle>
                  <CardDescription className="line-clamp-2">{product.description}</CardDescription>
                </div>
                <div className="flex space-x-1">
                  <Button
                    variant="ghost"
                    size="sm"
                    onClick={() => handleEdit(product)}
                  >
                    <Edit className="h-4 w-4" />
                  </Button>
                  <Button
                    variant="ghost"
                    size="sm"
                    onClick={() => handleDelete(product.id)}
                  >
                    <Trash2 className="h-4 w-4" />
                  </Button>
                </div>
              </div>
            </CardHeader>
            <CardContent>
              <div className="space-y-3">
                <div className="flex justify-between items-center">
                  <span className="text-lg font-bold">₦{product.price.toLocaleString()}</span>
                  {product.original_price && (
                    <span className="text-sm text-muted-foreground line-through">
                      ₦{product.original_price.toLocaleString()}
                    </span>
                  )}
                </div>
                
                <div className="flex items-center space-x-2">
                  <div className="flex items-center">
                    <Star className="h-3 w-3 fill-secondary text-secondary" />
                    <span className="text-sm ml-1">{product.rating}</span>
                  </div>
                  <span className="text-sm text-muted-foreground">({product.reviews})</span>
                </div>

                <div className="flex flex-wrap gap-1">
                  {product.benefits.slice(0, 2).map((benefit, index) => (
                    <Badge key={index} variant="outline" className="text-xs">
                      {benefit}
                    </Badge>
                  ))}
                  {product.benefits.length > 2 && (
                    <Badge variant="outline" className="text-xs">
                      +{product.benefits.length - 2} more
                    </Badge>
                  )}
                </div>

                <div className="flex space-x-2">
                  {product.is_new && <Badge variant="secondary">New</Badge>}
                  {product.is_bestseller && <Badge variant="default">Bestseller</Badge>}
                  {!product.in_stock && <Badge variant="destructive">Out of Stock</Badge>}
                </div>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  );
};

export default ProductManagement;
