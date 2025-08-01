"use client"

import { useEffect, useState } from "react";
import { supabase } from "@/integrations/supabase/client";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Leaf, Heart, Users, Award, Calendar, MapPin, Star } from "lucide-react";

interface PageContent {
  id: string;
  page_slug: string;
  title: string;
  content: any;
  published: boolean;
}

const Story = () => {
  const [pageContent, setPageContent] = useState<PageContent | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  // Default static content as fallback
  const storyTimeline = [
    {
      year: "2019",
      title: "The Beginning",
      description: "Sue and Monica reunited over a cup of hibiscus tea, discovering their shared passion for Nigerian herbal traditions.",
      icon: Heart
    },
    {
      year: "2020",
      title: "The Journey",
      description: "Traveled across Nigeria, learning from traditional healers and local farmers about medicinal plants and spices.",
      icon: MapPin
    },
    {
      year: "2021",
      title: "First Products",
      description: "Launched our first collection of premium tea blends and authentic Nigerian spices.",
      icon: Leaf
    },
    {
      year: "2022",
      title: "Community Growth",
      description: "Expanded our network of farmers and began supporting local communities.",
      icon: Users
    },
    {
      year: "2023",
      title: "Quality Recognition",
      description: "Received certifications for organic farming and quality standards.",
      icon: Award
    },
    {
      year: "2024",
      title: "Future Vision",
      description: "Continuing to innovate while honoring traditional wisdom and expanding our reach.",
      icon: Star
    }
  ];

  const coreValues = [
    {
      icon: Leaf,
      title: "Authenticity",
      description: "We honor traditional Nigerian methods and ingredients, ensuring every product carries the essence of our heritage."
    },
    {
      icon: Heart,
      title: "Wellness First",
      description: "Every blend is crafted with your health and wellbeing in mind, combining ancient wisdom with modern understanding."
    },
    {
      icon: Users,
      title: "Community",
      description: "We support local farmers and communities, creating sustainable partnerships that benefit everyone."
    },
    {
      icon: Award,
      title: "Excellence",
      description: "Rigorous quality standards ensure that every cup delivers the exceptional taste and benefits you deserve."
    }
  ];

  useEffect(() => {
    const fetchPageContent = async () => {
      try {
        const { data, error } = await supabase
          .from('page_content')
          .select('*')
          .eq('page_slug', 'story')
          .eq('published', true)
          .single();

        if (error) {
          // Check if it's a table doesn't exist error (42P01)
          if (error.code === '42P01') {
            console.log('page_content table does not exist, using static content');
            setPageContent(null);
          } else {
            console.log('No dynamic content found for story page, using static content');
            setPageContent(null);
          }
        } else {
          setPageContent(data);
        }
      } catch (error) {
        console.error('Error fetching story page content:', error);
        setPageContent(null);
      } finally {
        setLoading(false);
      }
    };

    fetchPageContent();
  }, []);

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

  // If we have dynamic content, render it
  if (pageContent && pageContent.content) {
    return (
      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div dangerouslySetInnerHTML={{ __html: pageContent.content.html || pageContent.content }} />
        </div>
      </div>
    );
  }

  // Fallback to static content
  return (
    <div className="py-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Hero Section */}
        <div className="text-center mb-16">
          <Badge variant="secondary" className="mb-4">Our Journey</Badge>
          <h1 className="text-4xl font-bold text-foreground mb-6">The Story of Sue&Mon</h1>
          <p className="text-lg text-muted-foreground max-w-3xl mx-auto leading-relaxed">
            From ancient Nigerian traditions to modern wellness, discover the journey that inspired Sue&Mon. 
            A tale of friendship, passion, and the healing power of nature.
          </p>
        </div>

        {/* Origin Story */}
        <div className="bg-gradient-subtle rounded-2xl p-8 mb-16">
          <div className="max-w-4xl mx-auto">
            <h2 className="text-2xl font-bold text-foreground mb-6 text-center">How It All Began</h2>
            <div className="space-y-6 text-muted-foreground">
              <p>
                In 2019, childhood friends Sue and Monica reunited over a cup of hibiscus tea and a meal seasoned with fresh Nigerian spices. 
                Both had experienced the transformative power of traditional Nigerian herbs and spices in their health and culinary journeys, 
                realizing these treasures deserved a place in modern wellness and cooking.
              </p>
              <p>
                What started as weekend experiments in Monica's kitchen quickly grew into a passion project. We spent months traveling across Nigeria, 
                learning from traditional healers and local cooks, meeting farmers, and understanding the rich heritage of our medicinal plants and culinary spices.
              </p>
              <p>
                Today, Sue&Mon is proud to offer premium tea blends and authentic spices that honor our cultural heritage while meeting the highest standards 
                of quality and purity. Every product tells a story of tradition, wellness, flavor, and the beautiful land we call home.
              </p>
            </div>
          </div>
        </div>

        {/* Timeline */}
        <div className="mb-16">
          <h2 className="text-2xl font-bold text-foreground mb-8 text-center">Our Journey Through Time</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {storyTimeline.map((item, index) => {
              const IconComponent = item.icon;
              return (
                <Card key={index} className="text-center hover:shadow-elegant transition-all duration-300">
                  <CardHeader>
                    <div className="bg-gradient-hero p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                      <IconComponent className="h-8 w-8 text-primary-foreground" />
                    </div>
                    <Badge variant="outline" className="mb-2">{item.year}</Badge>
                    <CardTitle className="text-lg">{item.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-base">
                      {item.description}
                    </CardDescription>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        </div>

        {/* Mission & Values */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
          <Card className="hover:shadow-elegant transition-all duration-300">
            <CardHeader>
              <CardTitle className="text-2xl">Our Mission</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4 text-muted-foreground">
              <p>
                We believe that wellness should be accessible, natural, and deeply rooted in tradition. Every tea and spice 
                we offer is sourced directly from trusted Nigerian farmers who share our commitment to quality and sustainability.
              </p>
              <p>
                Our mission is to bridge the gap between ancient wisdom and modern living, bringing you products that nourish 
                both body and soul while supporting local communities and preserving our cultural heritage.
              </p>
            </CardContent>
          </Card>

          <Card className="hover:shadow-elegant transition-all duration-300">
            <CardHeader>
              <CardTitle className="text-2xl">Our Vision</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4 text-muted-foreground">
              <p>
                To become the leading source for authentic Nigerian teas and spices, recognized globally for our commitment 
                to quality, tradition, and community impact.
              </p>
              <p>
                We envision a world where traditional healing wisdom is accessible to everyone, and where every cup of tea 
                tells a story of heritage, health, and hope.
              </p>
            </CardContent>
          </Card>
        </div>

        {/* Core Values */}
        <div className="mb-16">
          <h2 className="text-2xl font-bold text-foreground mb-8 text-center">What Drives Us</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {coreValues.map((value, index) => {
              const IconComponent = value.icon;
              return (
                <Card key={index} className="text-center hover:shadow-elegant transition-all duration-300">
                  <CardHeader>
                    <div className="bg-gradient-hero p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                      <IconComponent className="h-8 w-8 text-primary-foreground" />
                    </div>
                    <CardTitle className="text-lg">{value.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <CardDescription className="text-base">
                      {value.description}
                    </CardDescription>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        </div>

        {/* Call to Action */}
        <div className="text-center bg-gradient-subtle rounded-2xl p-8">
          <h2 className="text-2xl font-bold text-foreground mb-4">Join Our Story</h2>
          <p className="text-muted-foreground mb-6 max-w-2xl mx-auto">
            Experience the healing power of Nigerian traditions with our premium tea blends and authentic spices. 
            Every product carries the essence of our journey and the wisdom of generations.
          </p>
          <div className="flex justify-center space-x-4">
            <Badge variant="secondary" className="text-sm">Premium Quality</Badge>
            <Badge variant="secondary" className="text-sm">Traditional Methods</Badge>
            <Badge variant="secondary" className="text-sm">Community Support</Badge>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Story;