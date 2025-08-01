"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Story from "@/pages/Story";

export default function StoryPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Story />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 