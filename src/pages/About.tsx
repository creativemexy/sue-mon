"use client"

import { useEffect, useState } from "react";
import { supabase } from "@/integrations/supabase/client";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Leaf, Heart, Users, Award } from "lucide-react";

interface PageContent {
  id: string;
  page_slug: string;
  title: string;
  content: any;
  published: boolean;
}

const About = () => {
  const [pageContent, setPageContent] = useState<PageContent | null>(null);
  const [loading, setLoading] = useState(true);

  const defaultValues = [
    {
      icon: Leaf,
      title: "Natural & Pure",
      description: "We source only the finest organic teas and spices from trusted Nigerian farmers."
    },
    {
      icon: Heart,
      title: "Health First",
      description: "Every tea blend is carefully crafted with your wellness in mind."
    },
    {
      icon: Users,
      title: "Community Focused",
      description: "We support local communities and farmers."
    },
    {
      icon: Award,
      title: "Quality Excellence",
      description: "Our rigorous quality standards ensure exceptional taste."
    }
  ];

  const defaultTeam = [
    {
      name: "Sue Adebayo",
      role: "Co-Founder & CEO",
      bio: "A passionate herbalist with 15 years of experience."
    },
    {
      name: "Monica Okafor", 
      role: "Co-Founder & Head of Product",
      bio: "Former pharmaceutical researcher turned tea enthusiast."
    },
    {
      name: "Dr. Emeka Nwosu",
      role: "Chief Wellness Officer",
      bio: "Licensed naturopathic doctor specializing in herbal medicine."
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
          .eq('page_slug', 'about')
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
        console.error('Error fetching about page content:', error);
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
        <div className="text-center mb-16">
          <h1 className="text-4xl font-bold text-foreground mb-6">About Sue&Mon</h1>
          <p className="text-lg text-muted-foreground max-w-3xl mx-auto leading-relaxed">
            Founded by two passionate women, Sue and Monica, Sue&Mon was born from a shared vision to bring the healing power of Nigerian tea and spice traditions to modern wellness seekers and culinary enthusiasts.
          </p>
        </div>

        <div className="bg-gradient-subtle rounded-2xl p-8 mb-16">
          <div className="max-w-4xl mx-auto">
            <h2 className="text-2xl font-bold text-foreground mb-6 text-center">Our Story</h2>
            <div className="space-y-6 text-muted-foreground">
              <p>
                Sue&Mon began in 2019 when childhood friends Sue and Monica reunited over a cup of hibiscus tea and a meal seasoned with fresh Nigerian spices.
              </p>
              <p>
                What started as weekend experiments in Monica's kitchen quickly grew into a passion project. We spent months traveling across Nigeria, learning from traditional healers and local cooks.
              </p>
              <p>
                Today, Sue&Mon is proud to offer premium tea blends and authentic spices that honor our cultural heritage while meeting the highest standards of quality and purity.
              </p>
            </div>
          </div>
        </div>

        <div className="mb-16">
          <h2 className="text-2xl font-bold text-foreground mb-8 text-center">Our Values</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {defaultValues.map((value, index) => {
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

        <div>
          <h2 className="text-2xl font-bold text-foreground mb-8 text-center">Meet Our Team</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {defaultTeam.map((member, index) => (
              <Card key={index} className="text-center hover:shadow-elegant transition-all duration-300">
                <CardHeader>
                  <div className="w-24 h-24 bg-gradient-hero rounded-full mx-auto mb-4"></div>
                  <CardTitle className="text-lg">{member.name}</CardTitle>
                  <CardDescription className="font-semibold text-primary">
                    {member.role}
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <p className="text-muted-foreground">{member.bio}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default About; 