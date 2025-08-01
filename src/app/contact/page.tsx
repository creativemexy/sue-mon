"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Contact from "@/pages/Contact";

export default function ContactPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Contact />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 