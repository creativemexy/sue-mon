"use client"

import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Leaf, Star, ArrowRight, Shield, Truck } from "lucide-react";
import heroImage from "@/assets/hero-tea-image.jpg";

const Hero = () => {

  return (
    <section className="relative min-h-[80vh] flex items-center bg-gradient-to-br from-background via-muted/30 to-accent/20">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div className="space-y-8">
          <div className="space-y-4">
            <Badge variant="secondary" className="inline-flex items-center">
              <Leaf className="w-4 h-4 mr-2" />
              Premium Nigerian Tea & Spices
            </Badge>
            <h1 className="text-4xl lg:text-6xl font-bold leading-tight">
              <span className="text-foreground">Discover the</span>{" "}
              <span className="bg-gradient-hero bg-clip-text text-transparent">
                Ancient Wisdom
              </span>{" "}
              <span className="text-foreground">of Nigerian Tea & Spices</span>
            </h1>
            <p className="text-lg text-muted-foreground max-w-lg leading-relaxed">
              Experience the healing power of traditional Nigerian tea and spices, 
              carefully selected and blended for modern wellness. From immune support 
              to culinary excellence, discover your perfect blend of health and flavor.
            </p>
          </div>
          
          <div className="flex items-center space-x-6 text-sm">
            <div className="flex items-center space-x-2">
              <div className="flex -space-x-1">
                {[...Array(5)].map((_, i) => (
                  <Star key={i} className="w-4 h-4 fill-secondary text-secondary" />
                ))}
              </div>
              <span className="text-muted-foreground">4.9/5 from 2,400+ reviews</span>
            </div>
          </div>

          <div className="flex flex-col sm:flex-row gap-4">
            <Button size="lg" className="bg-gradient-hero text-primary-foreground hover:shadow-elegant transform hover:scale-105 border border-primary-glow/20 h-14 px-8 text-lg font-semibold group">
              Shop Tea & Spices
              <ArrowRight className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
            </Button>
            <Button variant="outline" size="lg" className="h-14 px-8 text-lg font-semibold">
              Learn About Benefits
            </Button>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8">
            <div className="flex items-center space-x-3">
              <div className="bg-primary/10 p-2 rounded-lg">
                <Shield className="w-5 h-5 text-primary" />
              </div>
              <div>
                <p className="font-medium text-sm">100% Natural</p>
                <p className="text-xs text-muted-foreground">No artificial additives</p>
              </div>
            </div>
            <div className="flex items-center space-x-3">
              <div className="bg-secondary/10 p-2 rounded-lg">
                <Truck className="w-5 h-5 text-secondary" />
              </div>
              <div>
                <p className="font-medium text-sm">Fast Delivery</p>
                <p className="text-xs text-muted-foreground">2-3 days across Nigeria</p>
              </div>
            </div>
            <div className="flex items-center space-x-3">
              <div className="bg-accent/20 p-2 rounded-lg">
                <Leaf className="w-5 h-5 text-primary" />
              </div>
              <div>
                <p className="font-medium text-sm">Sustainably Sourced</p>
                <p className="text-xs text-muted-foreground">Supporting local farmers</p>
              </div>
            </div>
          </div>
        </div>

        <div className="relative">
          <div className="relative rounded-2xl overflow-hidden shadow-warm">
            <img 
              src={heroImage.src}
              alt="Premium Nigerian tea and spices collection with traditional brewing equipment" 
              className="w-full h-[600px] object-cover"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-primary/20 via-transparent to-transparent"></div>
          </div>
          
          <div className="absolute -top-6 -left-6 bg-card border border-border rounded-xl p-4 shadow-elegant">
            <div className="flex items-center space-x-3">
              <div className="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
              <span className="text-sm font-medium">Fresh from farm</span>
            </div>
          </div>
          
          <div className="absolute -bottom-6 -right-6 bg-card border border-border rounded-xl p-4 shadow-elegant">
            <div className="text-center">
              <div className="text-2xl font-bold text-primary">2000+</div>
              <div className="text-xs text-muted-foreground">Happy customers</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;