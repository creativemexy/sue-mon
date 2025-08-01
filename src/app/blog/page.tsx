"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Blog from "@/pages/Blog";

export default function BlogPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Blog />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 